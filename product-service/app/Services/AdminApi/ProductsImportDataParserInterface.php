<?php

namespace App\Services\AdminApi;

interface ProductsImportDataParserInterface
{
    public function parse($json);

    public function parseSeedProductsData();
}
