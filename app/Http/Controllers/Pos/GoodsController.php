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
        $query = $query->get();

        foreach ($query as $q) {
            $q->setAppends(["sum_cost_link_raw_material"]);
        }
        // dd($qs);

        // $query->with("posLinkRawMaterials.rawMaterial:id,text");

        return response()->json([
            "goods" => $query,
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

    public function up_price_pos_goods()
    {
        $products = Goods::get();
        foreach ($products as $product) {
            $p = (int)($product->price * 1.07);
            $p = strval($p);
            $cp = strlen($p);

            if ($p[$cp - 1] >= 1 && $p[$cp - 1] <= 5) {
                $p[$cp - 1] = 5;
            } else if ($p[$cp - 1] >= 6 && $p[$cp - 1] <= 9) {
                $p[$cp - 1] = 0;
                $p = $p + 9;
            }

            // $product->price_vat_up = (int)$p;
            // $product->price_vat = $product->price * 1.07;
            $product->price = (int)$p;
            $product->update();
        }

        return $products;
    }
}
