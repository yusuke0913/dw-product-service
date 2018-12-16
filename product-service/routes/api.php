<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'prefix' => '/v1',
        'namespace' => 'Api\V1',
    ],
    function () {
        // collection
        Route::get('/collections', 'CollectionController@index');

        // product
        Route::get('/products', 'ProductController@index');
        Route::get('/products/detail/{id}', 'ProductController@detail');
        Route::get('/products/size/{size}', 'ProductController@size');
        Route::get('/products/collection/{collectionId}', 'ProductController@collection');
    }
);
