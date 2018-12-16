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

Route::prefix('/v1/collections')
    ->namespace('Api\V1')
    ->group(function () {
        Route::get('/', 'CollectionController@index');
    });


Route::prefix('/v1/products')
    ->namespace('Api\V1')
    ->group(function () {
        Route::get('/', 'ProductController@index');
    });
