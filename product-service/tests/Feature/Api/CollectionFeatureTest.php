<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionFeatureTest extends TestCase
{
    const NUM_OF_COLLECTION = 2;

    /**
     * @group collection
     */
    public function test_Request_WithNonParameter_ReturnAllList()
    {
        $response = $this->json('GET', '/api/v1/collections');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'collections' => [
                    self::$_collectionJsonStructure,
                ],
            ])
            ->assertJsonCount(self::NUM_OF_COLLECTION, 'collections');
        ;
    }

    private static $_collectionJsonStructure = [
        'id',
    ];
}
