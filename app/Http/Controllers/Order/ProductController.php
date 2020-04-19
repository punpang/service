<?php

namespace App\Http\Controllers\Order;

use App\Order\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function get()
    {
        $data = Product::with('ProductImage','ProductTag.ProductCategorySub.ProductCategory')->get();

        return response()->json($data, 200);
    }

    public function useonly()
    {
        $data = Product::UseOnly()->get();

        return response()->json($data, 200);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'price_normal' => 'required|numeric',
            'price_special_status' => "required|boolean",
            'price_special' => 'required|numeric',
            'status' => 'required|boolean',
            'image_status' => "required|boolean",
            'product_image_id' => "required|numeric"
        ]);

        $data = Product::create(request()->all());

        return response()->json($data, 200);
    }

    public function update(Product $id)
    {
 
        $id->update(request()->all());
        $id->save();

        return response()->json($id, 200);
    }
}
