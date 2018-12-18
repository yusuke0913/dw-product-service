<?php

namespace App\Http\Controllers\AdminApi\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AdminApi\ProductsJsonParserService;
use App\Model\Collection;
use App\Model\Product;
use App\Model\ImportLock;

class ImportController extends AdminApiBaseController
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $productsJson = $request->getContent();

        $parserService = new ProductsJsonParserService();
        $productsData = $parserService->parseJson($productsJson);

        if ($productsData === null) {
            throw new \App\Exceptions\InvalidParameterException();
        }

        $createdCollections = collect();
        $createdProducts = collect();
        $updatedCollections = collect();
        $updatedProducts = collect();

        try {
            \DB::transaction(function () use ($productsData, $createdCollections, $createdProducts, $updatedCollections, $updatedProducts) {
                // Lock to import only one data at a time
                $importLock = ImportLock::lock();

                $collectionMap = Collection::allByMapWithKeys();
                $productMap = Product::allByMapWithKeys();

                foreach ($productsData as $collectionData) {
                    $collectionId = $collectionData['collection'];
                    $size = (int) $collectionData['size'];
                    $productListData = $collectionData['products'];

                    if (!$collectionMap->has($collectionId)) {
                        $collection = new Collection();
                        $collection->id = $collectionId;
                        $collectionMap[$collectionId] = $collection;
                    }

                    $bulkUpdateProductIds = collect();
                    foreach ($productListData as $productData) {
                        $productId = $productData['sku'];
                        $productImage = $productData['image'];
                        $productName = $productData['name'];

                        if ($productMap->has($productId)) {
                            $currentProduct = $productMap[$productId];

                            if ($currentProduct->collection_id != $collectionId || $currentProduct->size != $size) {
                                $bulkUpdateProductIds[] = $productId;
                                $updatedProducts[$productId] = $currentProduct;
                                // logger("productId=${productId}  collectionId=${collectionId} size=${size}   currentProduct=${currentProduct}");
                            }

                            $shouldUpdate = false;

                            if ($currentProduct->name !== $productName) {
                                $shouldUpdate = true;
                                $currentProduct->name = $productName;
                            }

                            if ($currentProduct->image !== $productImage) {
                                $shouldUpdate = true;
                                $currentProduct->image = $productImage;
                            }

                            if ($shouldUpdate) {
                                $currentProduct->save();
                                $updatedProducts[$productId] = $currentProduct;
                            }
                        } else {
                            $product = new Product();
                            $product->id = $productId;
                            $product->name = $productName;
                            $product->image = $productImage;
                            $product->size = $size;
                            $product->collection_id = $collectionId;

                            $createdProducts[$productId] = $product;
                        }
                    }

                    if ($bulkUpdateProductIds->isNotEmpty()) {
                        Product::WhereIn('id', $bulkUpdateProductIds)
                            ->update(['size' => $size, 'collection_id' => $collectionId]);
                    }
                }

                if ($createdCollections->isNotEmpty()) {
                    Collection::bulkInsert($createdCollections);
                }

                if ($createdProducts->isNotEmpty()) {
                    Product::bulkInsert($createdProducts);
                }
            });
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        return response()->json([
            'createdCollections' => $createdCollections,
            'createdProducts' => $createdProducts,
            'updatedCollections' => $updatedCollections,
            'updatedProducts' => $updatedProducts,
        ]);
    }
}
