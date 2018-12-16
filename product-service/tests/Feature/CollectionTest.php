<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionTest extends TestCase
{
    public function test_Request_WithNonParameter_ReturnAllList()
    {
        $response = $this->get('/api/v1/collections');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'collections' => [
                    self::$_collectionJsonStructure,
                ],
            ])
        ;
    }

    private static $_collectionJsonStructure = [
        'id',
    ];

}
