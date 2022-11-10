<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pos\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        Order::create([
            "order_id" => $request->order_id,
            "pos_goods_id" => $request->pos_goods_id,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "total" => $request->total,
            "note" => $request->note
        ]);

        return response()->json([
            "title" => "ทำรายการสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function update(Order $id, Request $request)
    {
        $id->update([
            "price" => $request->price,
            "quantity" => $request->quantity,
            "total" => $request->total,
            "note" => $request->note
        ]);
        return response()->json([
            "title" => "ทำรายการสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function delete(Order $id)
    {
        $id->delete();

        return response()->json([
            "title" => "ทำรายการสำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
