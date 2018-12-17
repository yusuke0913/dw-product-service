<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportTest extends TestCase
{

    /**
     * @group import
     */
    public function test_RequestByGET_Return405()
    {
        $response = $this->get('/admin-api/v1/import');

        $response->assertStatus(405);
    }

    /**
     * @group import
     */

    public function test_RequestByPost_WithEmptyParameter_Return500()
    {
        $response = $this->post('/admin-api/v1/import');

        $response->assertStatus(500);
    }

    /**
     * @group import
     */

    public function test_RequestByPost_WithCollectJsonParameter_Return200()
    {
        $json = File::get("database/seeds/products.json");
        $param = json_decode($json, true);

        $response = $this->post('/admin-api/v1/import', $param);
        $response->assertStatus(200);
    }
}
