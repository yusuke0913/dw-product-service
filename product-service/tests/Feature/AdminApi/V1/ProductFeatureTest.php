<?php

namespace Tests\Feature\AdminApi\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AdminApi\ProductsJsonParserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
    protected function tearDown()
    {
        $this->artisan('migrate:refresh', ['--seed' => true]);
    }

    /**
     * @group import
     */
    public function test_RequestByGET_Return405()
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

        $response = $this->postJson(route('admin-api.v1.products.import'), $param);

        $response->assertOk()
            ->assertJson([
                'createdCollections' => [],
                'createdProducts' => [],
                'updatedCollections' => [],
                'updatedProducts' => [],
            ]);
        ;
    }

    /**
     * @group import
     */
    public function test_RequestByPost_WithAddTwoProductsJson_Return200()
    {
        $productsParam =
            [
                [
                    'sk' => 'Dummy-C99900217',
                    "name" =>  "Dummy-Classic Petite Melrose 28mm (Black)",
                    "image" => "Dummy-dw-petite-28-melrose-black-cat.png",
                    "size" =>  28,
                    "collection_id" => "classic-petite"
                ],
                [
                    'sk' => 'Dummy-C99900218',
                    "name" => "Dummy-Classic Petite Sterling 28mm (Black)",
                    "image" => "Dummy-dw-petite-28-sterling-black-cat.png",
                    "size" =>  28,
                    "collection_id" => "classic-petite"
                ],
            ]
        ;

        $param = [
            [
            'collection' => 'classic-petite',
            'size' => 28,
            'products' => $productsParam,
            ]
        ];

        // $json = ProductsJsonParserService::loadJsonFile("tests/Feature/AdminApi/import/addTwoProducts.json");
        // $param = json_decode($json, true);

        fwrite(STDOUT, json_encode($param));
        $response = $this->postJson(route('admin-api.v1.products.import'), $param);

        $response->assertOk()
            ->assertJson([
                'createdCollections' => [],
                'createdProducts' => $param,
                // 'createdProducts' => [
                //     'Dummy-C99900217' => [
                //         'id' => 'Dummy-C99900217',
                //         "name" =>  "Dummy-Classic Petite Melrose 28mm (Black)",
                //         "image" => "Dummy-dw-petite-28-melrose-black-cat.png",
                //         "size" =>  28,
                //         "collection_id" => "classic-petite"
                //     ],
                //     'Dummy-C99900218' => [
                //         'id' => 'Dummy-C99900218',
                //         "name" => "Dummy-Classic Petite Sterling 28mm (Black)",
                //         "image" => "Dummy-dw-petite-28-sterling-black-cat.png",
                //         "size" =>  28,
                //         "collection_id" => "classic-petite"
                //     ],
                // ],
                'updatedCollections' => [],
                'updatedProducts' => [],
            ]);
        ;
    }

    /**
     * @group import
     */
    public function test_RequestByPost_WithChangeThreeProductsName_Return200()
    {
        $json = ProductsJsonParserService::loadJsonFile("tests/Feature/AdminApi/import/changeThreeProductsNameFromTheSeed.json");
        $param = json_decode($json, true);

        $response = $this->postJson(route('admin-api.v1.products.import'), $param);

        $response->assertOk()
            ->assertJson([
                'createdCollections' => [],
                'createdProducts' => [],
                'updatedCollections' => [],
                'updatedProducts' => [
                    'C99900217' => [
                        'id' => 'C99900217',
                        "name" => "Dummy-Classic Petite Melrose 28mm (Black)",
                        "image" => "dw-petite-28-melrose-black-cat.png",
                        "size" =>  28,
                        "collection_id" => "classic-petite"
                    ],
                    'C99900161' => [
                        'id' => 'C99900161',
                        "name" => "Dummy-Classic Petite Melrose 32mm (Black)",
                        "image" => "petit-melrose-black.png",
                        "size" =>  32,
                        "collection_id" => "classic-petite"
                    ],
                    'RT88400084' => [
                        'id' => 'RT88400084',
                        "name" => "Dummy-Dapper Sheffield 38mm Rose Gold",
                        "image" => "dp38-sheffield-rg_3.png",
                        "size" =>  38,
                        "collection_id" => "dapper"
                    ],
                ]
            ]);
        ;
    }
}
