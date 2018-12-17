<?php

namespace App\Http\Controllers\AdminApi\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AdminApi\ProductsJsonParserService;
use App\Model\Collection;
use App\Model\Product;

class ImportController extends Controller
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

        try {
            \DB::transaction(function () use ($collectionMap, $productMap) {
                //todo lock

                $currentCollectionMap = Collection::allByMapWithKeys();
                $currentProductMap = Product::allByMapWithKeys();

                foreach ($collectionMap as $collectionId => $collection) {
                    if (!isset($currentCollectionMap[$collectionId])) {
                        $collection->save();
                    }
                }

                foreach ($productMap as $productId => $product) {
                    if (isset($currentProductMap[$productId])) {
                        $currentProduct = $currentProductMap[$productId];

                        if ($currentProduct->name !== $product->name) {
                            $currentProduct->name = $product->name;
                        }

                        if ($currentProduct->image !== $product->image) {
                            $currentProduct->image = $product->image;
                        }

                        if ($currentProduct->size !== $product->size) {
                            $currentProduct->size = $product->size;
                        }

                        if ($currentProduct->collection_id !== $product->collection_id) {
                            $currentProduct->collection_id = $product->collection_id;
                        }

                        $currentProduct->save();
                    } else {
                        $product->save();
                    }
                }
            });
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        return response()->json([
            'collections' => $collectionMap,
            'products' => $productMap,
        ]);
    }
}
