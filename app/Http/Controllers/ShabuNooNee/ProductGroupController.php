<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\ProductGroup;
use Auth;

class ProductGroupController extends Controller
{
    public function store()
    {
        $data = ProductGroup::create(request()->all());
        return response()->json([
            "status" => "success",
            "data" => $data,
            "message" => "สร้างกลุ่มสินค้าสำเร็จ"
        ], 200);
    }

    public function all()
    {
        $data = ProductGroup::get();
        return response()->json([
            "status" => "success",
            "data" => $data,
            "message" => "โหลดข้อมูลสำเร็จ"
        ], 200);
    }

    public function switchStatus(ProductGroup $id)
    {
        $id->update(["status" => request("status")]);
        //update(["product_categormy_id" => $product_category_id]);
        return response()->json([
            "status" => "success",
            "message" => "เปลี่ยนสถานะของ - " . $id->name . " - สำเร็จ"
        ], 200);
    }

    public function update(ProductGroup $id)
    {
        $id->update(["name" => request("name")]);
        //update(["product_category_id" => $product_category_id]);
        return response()->json([
            "status" => "success",
            "message" => "เปลี่ยนชื่อกลุ่มสำเร็จ"
        ], 200);
    }

    public function broths()
    {
        $data = ProductGroup::with("productUseOnly")->find(6);

        return response()->json($data, 200);
    }
}
