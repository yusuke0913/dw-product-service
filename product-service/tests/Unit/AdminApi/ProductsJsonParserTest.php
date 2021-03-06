<?php

namespace Tests\Unit\AdminApi;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AdminApi\ProductsJsonParserService;
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
        $result = $parserService->parse($dummyText);
        $this->assertNull($result);
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

        $result = $parserService->parse($incorrectJson);
        $this->assertNull($result);
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
        $result = $parserService->parse($incorrectJson);
        $this->assertNull($result);
    }

    /**
     * @group productsJsonParser
     *
     * @return void
     */
    public function test_LoadJson_WithCorrectJsonFormat_ReturnArray()
    {
        $parserService = new ProductsJsonParserService();
        $result = $parserService->parseSeedProductsData();
        $this->assertNotNull($result);
    }
}
