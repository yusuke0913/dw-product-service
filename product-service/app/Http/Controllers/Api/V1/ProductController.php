<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;

class ProductController extends Controller
{
    //

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::all();
        return response()->json([
            'products' => $products,
        ]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * $param string $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, string $id)
    {
        $product = Product::find($id);
        return response()->json([
            'product' => $product,
        ]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * $param int $size
     * @return \Illuminate\Http\Response
     */
    public function size(Request $request, int $size)
    {
        $products = Product::where('size', $size)->get()->map(function ($product) {
            return $product->id;
        });
        return response()->json([
            'productIds' => $products,
        ]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function collection(Request $request, $collectionId)
    {
        $products = Product::where('collection_id', $collectionId)->get()->map(function ($product) {
            return $product->id;
        });

        return response()->json([
            'productIds' => $products
        ]);
    }
}
