<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AdminApi\ProductsJsonParserService;

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
        $json = ProductsJsonParserService::loadSampleProductsJson();
        $param = json_decode($json, true);

        // $response = $this->post('/admin-api/v1/import', $param);
        $response = $this->json('POST', '/admin-api/v1/import', $param);

        $response->assertStatus(200);
    }
}
