<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pos\LinkRawMaterial;

class LinkRawMaterialsController extends Controller
{
    public function store(Request $request)
    {
        LinkRawMaterial::updateOrCreate(
            [
                "pos_goods_id" => $request->pos_goods_id,
                "pos_raw_material_id" => $request->pos_raw_material_id
            ],
            [
                "weight" => $request->weight,
                "cost" => $request->weight
            ]
        );


        return response()->json([
            "icon" => "success",
            "title" => "ทำรายการสำเร็จ",
            "text" => "ผูกวัตถุดิบเรียบร้อย"
        ], 200);
    }

    public function update(LinkRawMaterial $id, Request $request)
    {
        $id->update([
            "weight" => $request->weight,
            "cost" => $request->weight
        ]);

        return response()->json([
            "title" => "ทำรายการสำเร็จ",
            "text" => "แก้ไขผูกวัตถุดิบเรียบร้อย",
            "icon" => "success"
        ], 200);
    }

    public function remove(LinkRawMaterial $id)
    {
        $id->delete();

        return response()->json([
            "title" => "ทำรายการสำเร็จ",
            "text" => "ลบผูกวัตถุดิบเรียบร้อย",
            "icon" => "success"
        ], 200);
    }
}
