<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductFeatureTest extends TestCase
{
    const NUM_OF_SAMPLE_PRODUCTS = 51;

    /**
     * @group product
     */
    public function test_RequestAllList_WithNonParameter_ReturnAllList()
    {
        $response = $this->json('GET', '/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'products' => [
                    self::$_productJsonStructure,
                ],
            ])
            ->assertJsonCount(self::NUM_OF_SAMPLE_PRODUCTS, 'products');
        ;
    }

    /**
     * @group product
     */
    public function test_RequestDetail_WithNotExistsId_ReturnNull()
    {
        $productId = 'hoge';
        $response = $this->json('GET', "/api/v1/products/detail/${productId}");

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
        $response = $this->json('GET', "/api/v1/products/detail/${productId}");

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
        $response = $this->json('GET', "/api/v1/products/size/${size}");

        $response->assertStatus(200)
            ->assertJson([
                'productIds' => [],
            ])
            ->assertJsonCount(0, 'productIds');
        ;
    }

    const SIZE_28 = 28;
    const NUM_OF_PRODUCTS_WITH_SIZE_MAP = [ self::SIZE_28 => 26];

    /**
     * @group product
     */
    public function test_RequestSize_WithExistsSize_ReturnTheSameSizeProductList()
    {
        $size = self::SIZE_28;
        $expectingNum = self::NUM_OF_PRODUCTS_WITH_SIZE_MAP[$size];
        $response = $this->json('GET', "/api/v1/products/size/${size}");

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'productIds' => []
                ]
            )
            ->assertJsonCount($expectingNum, 'productIds');
        ;
    }

    /**
     * @group product
     */
    public function test_RequestCollection_WithNotExistsId_ReturnEmptyList()
    {
        $collectionId = 'NotExistsId';
        $response = $this->json('GET', "/api/v1/products/collection/${collectionId}");

        $response->assertStatus(200)
            ->assertJson([
                'productIds' => [],
            ])
            ->assertJsonCount(0, 'productIds');
        ;
    }

    const COLLECTION_ID_CLASSIC_PETITE = "classic-petite";

    const NUM_OF_PRODUCTS_WITH_COLLECTION_ID_MAP = [ self::COLLECTION_ID_CLASSIC_PETITE => 43];

    /**
     * @group product
     */
    public function test_RequestCollection_WithExistsCollectionId_ReturnList()
    {
        $collectionId = self::COLLECTION_ID_CLASSIC_PETITE;
        $response = $this->json('GET', "/api/v1/products/collection/${collectionId}");

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'productIds' => []
                ]
            )
            ->assertJsonCount(43, 'productIds');
        ;
    }

    private static $_productJsonStructure = [
        'id',
        'name',
        'image',
        'size',
    ];
}
