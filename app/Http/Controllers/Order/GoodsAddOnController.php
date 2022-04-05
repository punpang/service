<?php

namespace App\Http\Controllers\Order;

use App\Order\GoodsAddOn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsAddOnController extends Controller
{
    public function fetch(Request $request)
    {
        $goods_add_ons = GoodsAddOn::query();

        if ($request->get("id") != "undefined") {
            $goods_add_ons->where("id", $request->get("id"));
        }

        if ($request->get("name") != "undefined") {
            $goods_add_ons->where("name", $request->get("name"));
        }

        return $goods_add_ons->get();
    }

    public function updateOrCreate(Request $request)
    {
        $name_olded = "";
        if ($request->goods_add_on != null) {
            $name_olded = $request->goods_add_on["name"];
        }

        $goods_add_on = GoodsAddOn::updateOrCreate([
            "name" => $name_olded
        ], [
            "name" => $request->name
        ]);

        return response()->json([
            "data" => $goods_add_on,
            "status" => "success",
        ], 200);
    }
}
