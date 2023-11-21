<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pos\RawMaterial;

class RawMaterialsController extends Controller
{
    public function store(Request $request)
    {
        $data = RawMaterial::create([
            "text" => $request->text,
            "price" => $request->price,
            "weight" => $request->weight
        ]);

        return response()->json([
            // "data" => $data,
            "icon" => "success",
            "success" => true,
            "text" => "สร้างวัตถุดิบสำเร็จ",
            "title" => "ทำรายการสำเร็จ",
        ], 200);
    }

    public function fetch(Request $request)
    {
        $query = RawMaterial::query();

        if ($request->get("sortUpdatedAt") != null) {
            $query->orderBy("updated_at", $request->get("sortUpdatedAt"));
        }

        // if ($request->get("with") != null) {
        //     $explodes = explode(",", $request->get("with"));
        //     foreach ($explodes as $e) {
        //         $query->with($e);
        //     }
        // }

        return response()->json([
            "raw_materials" => $query->get(),
            "title" => "โหลดข้อมูลสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function update(RawMaterial $id, Request $request)
    {
        $id->update([
            "text" => $request->text,
            "price" => $request->price,
            "weight" => $request->weight,
        ]);

        foreach ($id->linkRawMaterials as $linkRawMaterial) {
            $linkRawMaterial->update([
                "cost" => $linkRawMaterial->weight
            ]);
        }

        return response()->json([
            "title" => "เปลี่ยนแปลงวัตถุดิบสำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
