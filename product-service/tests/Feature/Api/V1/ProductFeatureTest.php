<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductFeatureTest extends TestCase
{

    /** @var \Illuminate\Support\Collection $_seedProductsData */
    private $_seedsProductsData = null;

    protected function setUp()
    {
        parent::setUp();

        $seedData = \ProductsImportDataParser::parseSeedProductsData();
        $this->_seedsProductsData = collect($seedData);
    }

    /**
     * @group products
     */
    public function test_RequestAll_WithNonParameter_ReturnAllList()
    {
        $response = $this->getJson(route('api.v1.products.all'));
        $productSum = $this->_seedsProductsData->sum(function ($row) {
            return count($row['products']);
        });

        $response->assertOk()
            ->assertJsonStructure([
                'products' => [
                    self::$_productJsonStructure,
                ],
            ])
            ->assertJsonCount($productSum, 'products');
        ;
    }

    /**
     * @group products
     */
    public function test_RequestDetail_WithNotExistsId_ReturnNull()
    {
        $productId = 'dummyProductId';
        $response = $this->getJson(route('api.v1.products.detail', $productId));

        $response->assertOk()
            ->assertJson([
                'product' => null,
        ]);
    }

    /**
     * @group products
     */
    public function test_RequestDetail_WithExistsId_ReturnTheDetail()
    {
        $productId = 'C99900239';
        $response = $this->getJson(route('api.v1.products.detail', $productId));

        $response->assertOk()
            ->assertJsonStructure([
                'product' => self::$_productJsonStructure,
            ])
        ;
    }

    /**
     * @group products
     */
    public function test_RequestSize_WithNonExistsSize_ReturnEmptyList()
    {
        $size = -1;
        $response = $this->getJson(route('api.v1.products.size', $size));

        $response->assertOk()
            ->assertJson([
                'productIds' => [],
            ])
            ->assertJsonCount(0, 'productIds');
        ;
    }

    /**
     * @group products
     */
    public function test_RequestSize_WithExistsSize_ReturnTheSameSizeProductList()
    {
        $size = 28;
        $expectingNum = $this->_seedsProductsData
            ->filter(function ($row) use ($size) {
                return $size == $row['size'];
            })
            ->sum(function ($row) {
                return count($row['products']);
            });

        $response = $this->getJson(route('api.v1.products.size', $size));

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'productIds' => []
                ]
            )
            ->assertJsonCount($expectingNum, 'productIds');
        ;
    }

    /**
     * @group products
     */
    public function test_RequestCollection_WithNotExistsId_ReturnEmptyList()
    {
        $collectionId = 'DummyCollectionId';
        $response = $this->getJson(route('api.v1.products.collection', $collectionId));

        $response->assertOk()
            ->assertJson([
                'productIds' => [],
            ])
            ->assertJsonCount(0, 'productIds');
        ;
    }

    /**
     * @group products
     */
    public function test_RequestCollection_WithExistsCollectionId_ReturnList()
    {
        $collectionId = "classic-petite";
        $expectingNum = $this->_seedsProductsData
            ->filter(function ($row) use ($collectionId) {
                return $collectionId == $row['collection'];
            })
            ->sum(function ($row) {
                return count($row['products']);
            });

        $response = $this->getJson(route('api.v1.products.collection', $collectionId));

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'productIds' => []
                ]
            )
            ->assertJsonCount($expectingNum, 'productIds');
        ;
    }

    /**
     * @group collection
     */
    public function test_RequestCollections_WithNonParameter_ReturnCollectionList()
    {
        $response = $this->getJson(route('api.v1.products.collections'));

        $collectionNum = 2;
        $response->assertOk()
            ->assertJsonStructure([
                'collections' => [
                    self::$_collectionJsonStructure,
                ],
            ])
            ->assertJsonCount($collectionNum, 'collections');
        ;
    }

    private static $_productJsonStructure = [
        'id',
        'name',
        'image',
        'size',
    ];

    private static $_collectionJsonStructure = [
        'id',
    ];
}
