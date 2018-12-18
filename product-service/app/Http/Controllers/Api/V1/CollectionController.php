<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Model\Collection;

class CollectionController extends ApiBaseController
{


    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collections = Collection::all();
        return response()->json([
            'collections' => $collections,
        ]);
    }
}
