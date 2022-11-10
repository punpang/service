<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pos\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {

        $order = Order::where([
            "order_id" => $request->order_id,
            "pos_goods_id" => $request->pos_goods_id,
            "note" => $request->note,
            "price" => $request->price
        ])->first();

        if ($order) {
            $order->update([
                "price" => $request->price,
                "quantity" => $order->quantity + $request->quantity,
                "total" => $request->total,
                "note" => $request->note
            ]);
        } else {
            Order::create([
                "order_id" => $request->order_id,
                "pos_goods_id" => $request->pos_goods_id,
                "price" => $request->price,
                "quantity" => $request->quantity,
                "total" => $request->total,
                "note" => $request->note
            ]);
        }

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

        $orders = Order::where([
            "order_id" => $id->order_id,
            "pos_goods_id" => $id->pos_goods_id,
            "note" => $id->note,
            "price" => $id->price
        ])->get();

        if ($orders->count() > 1) {
            foreach ($orders as $key => $order) {
                if ($key > 0) {
                    $orders[0]->update([
                        "quantity" => $orders[0]->quantity + $order->quantity,
                    ]);
                    $order->delete();
                }
            }
        }

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
