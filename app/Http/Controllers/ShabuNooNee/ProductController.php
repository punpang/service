<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\Product;

class ProductController extends Controller
{
    public function store()
    {
        //dd(request()->all());
        $store = Product::create(request()->all());
        $data = Product::afterStore($store->id);

        return response()->json(
            [
                "data" => $data,
                "status" => "success",
                "message" => "เพิ่มสินค้าใหม่สำเร็จ"
            ],
            200
        );
    }

    public function all()
    {
        //dd(request()->all());
        $data = Product::with("productGroup", "googlgImage")->get();
        return response()->json(
            [
                "data" => $data,
                "status" => "success",
                "message" => "โหลดข้อมูลสำเร็จ"
            ],
            200
        );
    }
}
