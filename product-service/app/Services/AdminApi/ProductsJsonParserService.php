<?php

namespace App\Services\AdminApi;

use App\Model\Product;

class ProductsJsonParserService
{
    private static $_SEED_PRODUCTS_JSON_FILE_PATH = "database/seeds/products.json";

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

    public static function loadSeedProductsJson()
    {
        $path = base_path() . '/' . self::$_SEED_PRODUCTS_JSON_FILE_PATH;
        return \File::get($path);
    }

    public function parseSeedProductsData()
    {
        $json = self::loadSeedProductsJson();
        return $this->parseJson($json);
    }
}
