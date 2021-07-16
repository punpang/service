<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\TableOrder;
use App\ShabuNooNee\DiningTable;
use App\ShabuNooNee\TableOrderDetail;
use App\ShabuNooNee\ProductGroup;
use App\ShabuNooNee\Product;
use Auth;
use Illuminate\Support\Arr;

class TableOrderController extends Controller
{
    public function self()
    {
        $data = DiningTable::whereUserId(Auth::user()->id)
            ->whereIn("status_id", [1, 2, 3])
            ->with("detailTable", "priceRange")
            ->first();
        return response()->json(
            [
                'data' => $data
            ],
            200
        );
    }
    public function productGroupAllow()
    {
        $productGroupAllow =  explode(",", request("productGroupAllow"));
        $data = ProductGroup::whereIn("id", $productGroupAllow)
            ->whereStatus(1)
            ->with("product", "product.googlgImage")
            ->get();
        return response()->json(
            [
                'data' => $data
            ],
            200
        );
    }

    public function testStore()
    {
        $input = request()->all();
        dd($input);
        foreach ($input as $key => $value) {
            if ($value == null) {
                unset($key);
            }
        }
        return $input;
    }

    public function store() // เพิ่มรายการสั่งอาหาร และ รายละเอียด
    {
        // $input = request()->all();

        // ตรวจสอบว่า รายการอาหารเกิน 20 ถาดไหม
        if (request("sumCountProduct") > 20) {
            return response()->json(
                [
                    "message" => "รายการอาหารเกิน 20 ถาด"
                ],
                201
            );
        }
        //dd($input);

        //สร้างรายการอาหารใหม่
        $newTableOrder = new TableOrder;
        $newTableOrder->dining_table_id = request("diningTableId");
        $newTableOrder->save();

        //เก็บสินค้าที่หมด
        $productOutOfStock = [];

        // สร้างรายละเอียดของรายการอาหาร
        foreach (request("products") as $product) {
            // ตรวจสอบว่ามีสินค้าพร้อมเสิร์ฟไหม true คือ มีสินค้า และเพิ่มลงรายละเอียด
            if (Product::checkProductUse($product["id"]) === true) {
                // ตรวจสอบว่าสินค้าที่เข้ามีจำนวนมากกว่า 0
                if ($product["quantity"] > 0) {
                    $newTableOrderDetail = new TableOrderDetail;
                    $newTableOrderDetail->table_order_id = $newTableOrder->id;
                    $newTableOrderDetail->product_id = $product["id"];
                    $newTableOrderDetail->price = $product["price"];
                    $newTableOrderDetail->quantity = $product["quantity"];
                    $newTableOrderDetail->sum_price = $product["sumPrice"];
                    $newTableOrderDetail->status_free = $product["status_free"];
                    $newTableOrderDetail->save();
                }
            } else {
                $productOutOfStock[] = $product["title"];
            }
        }

        dd($productOutOfStock);
    }
}
