<?php

namespace Tests\Unit\AdminApi;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AdminApi\ProductsJsonParserService;
use App\Model\Collection;
use App\Model\Product;

class ProductsJsonParserTest extends TestCase
{

    /**
     * @group productsJsonParser
     *
     * @return void
     */
    public function test_LoadJson_WithText_ReturnNull()
    {
        $parserService = new ProductsJsonParserService();
        $dummyText = 'dummyText';
        $loadedProducts = $parserService->parseJson($dummyText);
        $this->assertNull($loadedProducts);
    }

    /**
     * @group productsJsonParser
     *
     * @return void
     */
    public function test_LoadJson_WithEmptyArray_ReturnNull()
    {
        $parserService = new ProductsJsonParserService();
        $incorrectJson = json_encode([]);

        $loadedProducts = $parserService->parseJson($incorrectJson);
        $this->assertNull($loadedProducts);
    }

    /**
     * @group productsJsonParser
     *
     * @return void
     */
    public function test_LoadJson_WithIncorrectJsonFormat_ReturnNull()
    {
        $parserService = new ProductsJsonParserService();
        $incorrectJson = json_encode([
            'dummyProperty1' => 1,
            'dummyProperty2' => 1,
        ]);
        $loadedProducts = $parserService->parseJson($incorrectJson);
        $this->assertNull($loadedProducts);
    }

    /**
     * @group productsJsonParser
     *
     * @return void
     */
    public function test_LoadJson_WithCorrectJsonFormat_ReturnArray()
    {
        $parserService = new ProductsJsonParserService();
        $json = ProductsJsonParserService::loadSampleProductsJson();
        [$collectionMap, $productMap] = $parserService->parseJson($json);

        $this->assertNotNull($collectionMap);
        $this->assertCount(2, $collectionMap);
        $this->assertInstanceOf(Collection::class, array_shift($collectionMap));

        $this->assertNotNull($productMap);
        $this->assertCount(51, $productMap);
        $this->assertInstanceOf(Product::class, array_shift($productMap));
    }
}
