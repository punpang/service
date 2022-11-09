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

        if ($request->get("sortUpdatedAt") != "undefined") {
            $query->orderBy("updated_at", $request->get("sortUpdatedAt"));
        }

        if ($request->get("with") != null) {
            $explodes = explode(",", $request->get("with"));
            foreach ($explodes as $e) {
                $query->with($e);
            }
        }

        return response()->json([
            "goods" => $query->get(),
            "title" => "โหลดข้อมูลสำเร็จ",
            "icon" => "success"
        ], 200);
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
            "title" => "เปลี่ยนแปลงสินค้าสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function updateStatusUse(Goods $id)
    {
        $id->status_use = $id->status_use = !$id->status_use;
        $id->save();

        return response()->json([
            "title" => "เปลี่ยนแปลงสำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
