<?php

namespace App\Http\Controllers\AdminApi\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $importedProducts = json_decode($request->getContent(), true);
        if ($importedProducts === null) {
            throw new \Exception('INVALID_PARAMETER');
        }

        return response()->json([
            'importedProducts' => $importedProducts,
        ]);
    }
}
