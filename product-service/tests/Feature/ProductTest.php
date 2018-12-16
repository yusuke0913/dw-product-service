<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testList()
    {
        $response = $this->get('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'products' => [],
            ])
        ;
    }
}
