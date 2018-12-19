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

// Route::name('admin.')->group(function () {
Route::group(
    [
        'prefix' => '/v1',
        'namespace' => 'V1',
        'as' => 'api.v1.'
    ],
    function () {

        // products
        Route::group(
            [
                'prefix' => '/products',
                'as' => 'products.',
            ],
            function () {
                Route::get('/all', 'ProductController@index')
                    ->name('all');
                Route::get('/detail/{id}', 'ProductController@detail')
                    ->name('detail');
                Route::get('/size/{size}', 'ProductController@size')
                    ->name('size');
                Route::get('/collection/{collectionId}', 'ProductController@collection')
                    ->name('collection');
                Route::get('/collections', 'ProductController@collections')
                    ->name('collections');
            }
        );
    }
);
