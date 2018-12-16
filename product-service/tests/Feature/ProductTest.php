<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    public function test_RequestAllList_WithNonParameter_ReturnAllList()
    {
        $response = $this->get('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'products' => [
                    self::$_productJsonStructure,
                ],
            ])
        ;
    }

    public function test_RequestDetail_WithNotExistsId_ReturnNull()
    {
        $productId = 'hoge';
        $response = $this->get("/api/v1/products/detail/${productId}");

        $response->assertStatus(200)
            ->assertJson([
                'product' => null,
        ]);
    }

    public function test_RequestDetail_WithExistsId_ReturnTheDetail()
    {
        $productId = '38WRDDIBTC';
        $response = $this->get("/api/v1/products/detail/${productId}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'product' => self::$_productJsonStructure,
            ])
        ;
    }

    public function test_RequestSize_WithNonExistsSize_ReturnEmptyList()
    {
        $size = -1;
        $response = $this->get("/api/v1/products/size/${size}");

        $response->assertStatus(200)
            ->assertJson([
                'products' => [],
            ])
        ;
    }

    public function test_RequestSize_WithExistsSize_ReturnTheSameSizeProductList()
    {
        $size = 28;
        $response = $this->get("/api/v1/products/size/${size}");

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'products' => [
                        self::$_productJsonStructure,
                    ]
                ]
            )
        ;
    }

    public function test_RequestCollection_WithNotExistsId_ReturnEmptyList()
    {
        $collectionId = 'NotExistsId';
        $response = $this->get("/api/v1/products/collection/${collectionId}");

        $response->assertStatus(200)
            ->assertJson([
                'products' => [],
            ])
        ;
    }

    public function test_RequestCollection_WithExistsCollectionId_ReturnList()
    {
        $collectionId = 'Bernie Barton';
        $response = $this->get("/api/v1/products/collection/${collectionId}");
        
        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'products' => [
                        self::$_productJsonStructure,
                    ]
                ]
            )
        ;
    }

    private static $_productJsonStructure = [
        'id',
        'name',
        'image',
        'size',
        'collection_id',
    ];
}
