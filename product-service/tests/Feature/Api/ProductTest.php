<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * @group product
     */
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

    /**
     * @group product
     */
    public function test_RequestDetail_WithNotExistsId_ReturnNull()
    {
        $productId = 'hoge';
        $response = $this->get("/api/v1/products/detail/${productId}");

        $response->assertStatus(200)
            ->assertJson([
                'product' => null,
        ]);
    }

    /**
     * @group product
     */
    public function test_RequestDetail_WithExistsId_ReturnTheDetail()
    {
        $productId = 'C99900239';
        $response = $this->get("/api/v1/products/detail/${productId}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'product' => self::$_productJsonStructure,
            ])
        ;
    }

    /**
     * @group product
     */
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

    /**
     * @group product
     */
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

    /**
     * @group product
     */
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

    /**
     * @group product
     */
    public function test_RequestCollection_WithExistsCollectionId_ReturnList()
    {
        $collectionId = 'classic-petite';
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
