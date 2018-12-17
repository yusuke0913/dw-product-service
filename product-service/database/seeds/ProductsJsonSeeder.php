<?php

use Illuminate\Database\Seeder;
use App\Services\AdminApi\ProductsJsonParserService;

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
        $json = ProductsJsonParserService::loadSampleProductsJson();
        [$collectionMap, $productMap] = $parserService->parseJson($json);

        foreach ($collectionMap as $collection) {
            $collection->save();
        }

        foreach ($productMap as $product) {
            $product->save();
        }
    }
}
