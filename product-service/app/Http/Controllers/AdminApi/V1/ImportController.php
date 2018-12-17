<?php

namespace App\Http\Controllers\AdminApi\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AdminApi\ProductsJsonParserService;

class ImportController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $productsJson = $request->getContent();
        // \Log::info(var_export($productsJson, true));

        $parserService = new ProductsJsonParserService();
        [$collections, $products] = $parserService->parseJson($productsJson);

        if ($collections === null) {
            throw new \Exception('INVALID_PARAMETER');
        }

        return response()->json([
            'collections' => $collections,
            'products' => $products,
        ]);
    }
}
