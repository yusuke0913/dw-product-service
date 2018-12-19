<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => '/v1',
        'namespace' => 'V1',
        'as' => 'admin-api.v1.'
    ],
    function () {

        // products
        Route::group(
            [
                'prefix' => '/products',
                'as' => 'products.',
            ],
            function () {
                Route::post('/import', 'ProductsController@import')
                    ->name('import');
            }
        );
    }
);
