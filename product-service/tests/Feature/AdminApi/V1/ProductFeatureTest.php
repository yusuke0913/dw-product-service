<?php

namespace Tests\Feature\AdminApi\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AdminApi\ProductsJsonParserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Model\Product;

class ProductTest extends TestCase
{
    protected function tearDown()
    {
        $this->artisan('migrate:refresh', ['--seed' => true]);
    }

    /**
     * @group import
     */
    public function test_RequestByGet_Return405()
    {
        $response = $this->getJson(route('admin-api.v1.products.import'));

        $response->assertStatus(405);
    }

    /**
     * @group import
     */
    public function test_RequestByPost_WithEmptyJson_Return500()
    {
        $response = $this->postJson(route('admin-api.v1.products.import'), []);

        $response->assertStatus(500)
            ->assertJson(
                [
                    'error' => true,
                    'errorMessage' => 'INVALID_PARAMETER'
                ]
            );
    }

    /**
     * @group import
     */
    public function test_RequestByPost_WithIncorrectJson_Return500()
    {
        $response = $this->postJson(route('admin-api.v1.products.import'), [ "DummyProperty1" => 1, "DummyProperty2" => 2, ]);

        $response->assertStatus(500)
            ->assertJson(
                [
                    'error' => true,
                    'errorMessage' => 'INVALID_PARAMETER'
                ]
            );
    }

    /**
     * @group import
     */
    public function test_RequestByPost_WithTheSameProductsSeedJson_Return200()
    {
        $seedJson = ProductsJsonParserService::loadSeedProductsJson();
        $param = json_decode($seedJson, true);

        $beforeAllProducts = Product::all();

        $response = $this->postJson(route('admin-api.v1.products.import'), $param);

        $afterAllProducts = Product::all();

        $response->assertOk();
        $this->assertEquals($beforeAllProducts, $afterAllProducts);
    }

    /**
     * @group import
     */
    public function test_RequestByPost_WithAddTwoProductsJson_Return200()
    {
        $json = ProductsJsonParserService::loadJsonFile("tests/Feature/AdminApi/import/addTwoProducts.json");
        $param = json_decode($json, true);

        $targetProductIds = collect($param)->map(function ($row) {
            return collect($row['products'])->pluck('sku');
        });

        $beforeAllProducts = Product::all();
        $beforeTargetProducts = Product::whereIn('id', $targetProductIds)->get();

        $response = $this->postJson(route('admin-api.v1.products.import'), $param);

        $afterAllProducts = Product::all();
        $afterTargetProducts = Product::whereIn('id', $targetProductIds)->get();

        $response->assertOk();
        $this->assertEquals(0, $beforeTargetProducts->count());
        $this->assertNotEquals($beforeAllProducts, $afterAllProducts);
        $this->assertEquals($targetProductIds->count(), $afterTargetProducts->count());
    }

    /**
     * @group import
     */
    public function test_RequestByPost_WithChangeThreeProductsName_Return200()
    {
        $json = ProductsJsonParserService::loadJsonFile("tests/Feature/AdminApi/import/changeThreeProductsNameFromTheSeed.json");
        $param = json_decode($json, true);

        $targetProductIds = collect($param)->map(function ($row) {
            return collect($row['products'])->pluck('sku');
        });

        $beforeAllProducts = Product::all();
        $beforeTargetProducts = Product::whereIn('id', $targetProductIds)->get();

        $response = $this->postJson(route('admin-api.v1.products.import'), $param);

        $afterTargetProducts = Product::whereIn('id', $targetProductIds)->get();
        $afterAllProducts = Product::all();

        $response->assertOk();

        $this->assertNotEquals($beforeAllProducts, $afterAllProducts);
        $this->assertNotEquals($beforeTargetProducts, $afterTargetProducts);
    }
}
