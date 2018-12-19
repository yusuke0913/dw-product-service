<?php

use Illuminate\Database\Seeder;
use App\Services\AdminApi\ProductsJsonParserService;
use App\Model\Collection;
use App\Model\Product;

class ProductsJsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parserService = new ProductsJsonParserService();
        $json = ProductsJsonParserService::loadSeedProductsJson();
        $productsJson= $parserService->parseJson($json);

        $collectionMap = [];
        $productMap = [];
        foreach ($productsJson as $collectionData) {
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

        foreach ($collectionMap as $collection) {
            $collection->save();
        }

        foreach ($productMap as $product) {
            $product->save();
        }
    }
}
