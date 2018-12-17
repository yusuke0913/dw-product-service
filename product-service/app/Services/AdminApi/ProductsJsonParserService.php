<?php

namespace App\Services\AdminApi;

use App\Model\Collection;
use App\Model\Product;

class ProductsJsonParserService
{
    private static $_SAMPLE_PRODUCTS_JSON_FILE_PATH = "database/seeds/products.json";

    public function parseJson($json)
    {
        $loadedData = json_decode($json, true);

        if (!$this->isValidDataFormat($loadedData)) {
            return null;
        }

        $collectionMap = [];
        $productMap = [];
        foreach ($loadedData as $collectionData) {
            $collectionId = $collectionData['collection'];
            $size = (int) $collectionData['size'];
            $productListData = $collectionData['products'];

            if (!isset($collectionMap[$collectionId])) {
                $collection = new Collection();
                $collection->id = $collectionId;
                $collectionMap[$collectionId] = $collection;
            }

            foreach ($productListData as $productData) {
                $productId = $productData['sku'];
                $productImage = $productData['image'];
                $productName = $productData['name'];

                $product = new Product();
                $product->id = $productId;
                $product->name = $productName;
                $product->image = $productImage;
                $product->size = $size;
                $product->collection_id = $collectionId;

                $productMap[$productId] = $product;
            }
        }

        return [$collectionMap, $productMap];
    }

    private function isValidDataFormat($data)
    {
        if (!is_array($data) || empty($data)) {
            return false;
        }

        foreach ($data as $row) {
            if (!isset($row['collection']) || !isset($row['size']) || !isset($row['products'])) {
                return false;
            }
        }

        return true;
    }

    public static function loadSampleProductsJson()
    {
        return \File::get(self::$_SAMPLE_PRODUCTS_JSON_FILE_PATH);
    }
}
