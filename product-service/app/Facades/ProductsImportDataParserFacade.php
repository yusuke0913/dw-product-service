<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductsImportDataParserFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'products.import.data.parser';
    }
}
