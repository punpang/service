<?php

namespace App\Http\Controllers\Punpang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Punpang\Product;

class ProductController extends Controller
{
    public function fetchAllUse()
    {
        $data = Product::with("prices.size", "productDetail")->orderBy("type", "asc")->get();

        return response()->json($data, 200);
    }
}
