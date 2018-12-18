<?php

namespace App\Services\AdminApi;

use App\Model\Collection;
use App\Model\Product;

class ProductsJsonParserService
{
    private static $_SAMPLE_PRODUCTS_JSON_FILE_PATH = "database/seeds/products.json";

    public function parseJson($json)
    {
        $result = json_decode($json, true);

        if (!$this->isValidDataFormat($result)) {
            return null;
        }

        return $result;
    }

    private function isValidDataFormat($data)
    {
        if (!is_array($data) || empty($data)) {
            return false;
        }

        foreach ($data as $row) {
            if (!isset($row['collection']) || !isset($row['size']) || !isset($row['products'])) {
                return false;
            }
        }

        return true;
    }

    public static function loadJsonFile($filePath)
    {
        return \File::get($filePath);
    }

    public static function loadSampleProductsJson()
    {
        return self::loadJsonFile(self::$_SAMPLE_PRODUCTS_JSON_FILE_PATH);
    }

}
