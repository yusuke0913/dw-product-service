<?php

use Illuminate\Database\Seeder;
use App\Services\AdminApi\ProductsJsonParserService;
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
        $productsJson = $parserService->parseSeedProductsData();

        $collectionMap = [];
        $productMap = [];
        foreach ($productsJson as $collectionData) {
            $collectionId = $collectionData['collection'];
            $size = (int) $collectionData['size'];
            $productListData = $collectionData['products'];

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

        foreach ($productMap as $product) {
            $product->save();
        }
    }
}
