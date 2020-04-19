<?php

namespace App\Http\Controllers\Punpang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Punpang\Product;

class ProductController extends Controller
{
    public function index()
    {
      $products = Product::orderBy('type','ASC')->get();
      return view('punpang/product/index' , compact('products'));
    }

    public function ProductId($id)
    {
      $product = Product::findOrfail($id);
      return view('punpang/product/show' , compact('product'));
    }
}
