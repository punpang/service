<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pos\Goods;

class GoodsController extends Controller
{
    public function store(Request $request)
    {
        Goods::create([
            "text" => $request->text,
            "pos_category_goods_id" => $request->pos_category_goods_id,
            "status_use" => $request->status_use,
            "price" => $request->price,
        ]);
        return response()->json([
            "title" => "สร้างสินค้าสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function fetch(Request $request)
    {
        $query = Goods::query();

        if ($request->get("raw") == true) {
            return $query->with("categoryGoodses")->get();
        }

        return $query->get();
    }

    public function update(Goods $id, Request $request)
    {
        $id->update([
            "text" => $request->text,
            "pos_category_goods_id" => $request->pos_category_goods_id,
            "status_use" => $request->status_use,
            "price" => $request->price,
        ]);

        return response()->json([
            "title" => "สร้างสินค้าสำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
