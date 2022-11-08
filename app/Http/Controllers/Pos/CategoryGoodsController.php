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

    public function fetch()
    {
        $datas = CategoryGoods::whereStatusUse(true)->get();

        return response()->json([
            "category_goods" => $datas,
            "title" => "โหลดข้อมูลสำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
