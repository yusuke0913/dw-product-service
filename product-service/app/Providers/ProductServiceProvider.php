<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AdminApi\ProductsJsonParserService;
use App\Services\AdminApi\ProductsImportDataParserInterface;

class ProductServiceProvider extends ServiceProvider
{
    // protected $defer = true;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductsImportDataParserInterface::class, function () {
            return new ProductsJsonParserService();
        });
        $this->app->alias(ProductsImportDataParserInterface::class, 'products.import.data.parser');
    }
}
