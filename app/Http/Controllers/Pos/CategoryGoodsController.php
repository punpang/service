<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pos\CategoryGoods;

class CategoryGoodsController extends Controller
{
    public function store(Request $request)
    {
        CategoryGoods::create([
            "text" => $request->text,
            "status_use" => $request->status_use,
        ]);

        return response()->json([
            "title" => "สร้างประเภทสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function fetch(Request $request)
    {
        $query = CategoryGoods::query();

        if ($request->get("sortUpdatedAt") != null) {
            $query->orderBy("updated_at", $request->get("sortUpdatedAt"));
        }

        if ($request->get("with") != null) {
            $explodes = explode(",", $request->get("with"));
            foreach ($explodes as $e) {
                $query->with($e);
            }
        }

        return response()->json([
            "category_goods" => $query->get(),
            "title" => "โหลดข้อมูลสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function update(CategoryGoods $id, Request $request)
    {
        $id->update([
            "text" => $request->text,
            "status_use" => $request->status_use,
        ]);


        return response()->json([
            "title" => "เปลี่ยนแปลงประเภทสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function updateStatusUse(CategoryGoods $id)
    {
        $id->status_use = $id->status_use = !$id->status_use;
        $id->save();

        return response()->json([
            "title" => "เปลี่ยนแปลงสำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
