<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\Product;
use App\ShabuNooNee\TableOrderDetail;

class TableOrderDetailController extends Controller
{
    public function updateById(TableOrderDetail $table_order_detail_id, Request $request)
    {
        return $table_order_detail_id;
        $quantityOld = $table_order_detail_id->quantity;

        // จำนวน(เก่า) น้อยกว่า จำนวน(ใหม่)
        if ($quantityOld <= $request->quantity) {
            return response()->json([
                "msg" => "จำนวน(เก่า) น้อยกว่า จำนวน(ใหม่)"
            ], 201);
        }

        // อัปเดทจำนวนใหม่
        $table_order_detail_id->quantity = $request->quantity;
        $table_order_detail_id->save();

        Product::outOfStockByID($table_order_detail_id->product_id);
    }
}
