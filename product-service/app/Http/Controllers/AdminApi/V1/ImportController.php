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
        [$collectionMap, $productMap] = $parserService->parseJson($productsJson);

        if ($collectionMap === null) {
            throw new \App\Exceptions\InvalidParameterException();
        }

        $createdCollections = collect();
        $createdProducts = collect();
        $updatedCollections = collect();
        $updatedProducts = collect();

        try {
            \DB::transaction(function () use ($collectionMap, $productMap, $createdCollections, $createdProducts, $updatedCollections, $updatedProducts) {
                // Lock to import only one data at a time
                $importLock = ImportLock::lock();

                $currentCollectionMap = Collection::allByMapWithKeys();
                $currentProductMap = Product::allByMapWithKeys();

                foreach ($collectionMap as $collectionId => $collection) {
                    if (!isset($currentCollectionMap[$collectionId])) {
                        $createdCollections[] = $collection;
                    }
                }

                Collection::bulkInsert($createdCollections);

                foreach ($productMap as $productId => $product) {
                    if (isset($currentProductMap[$productId])) {
                        $currentProduct = $currentProductMap[$productId];

                        $shouldUpdate = false;
                        if ($currentProduct->name !== $product->name) {
                            $shouldUpdate = true;
                            $currentProduct->name = $product->name;
                        }

                        if ($currentProduct->image !== $product->image) {
                            $shouldUpdate = true;
                            $currentProduct->image = $product->image;
                        }

                        if ($currentProduct->size !== $product->size) {
                            $shouldUpdate = true;
                            $currentProduct->size = $product->size;
                        }

                        if ($currentProduct->collection_id !== $product->collection_id) {
                            $shouldUpdate = true;

                            $currentProduct->collection_id = $product->collection_id;
                        }

                        if ($shouldUpdate) {
                            $currentProduct->save();
                            $updatedProducts[] = $currentProduct;
                        }
                    } else {
                        $createdProducts[] = $product;
                    }
                }
                Product::bulkInsert($createdProducts);
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
