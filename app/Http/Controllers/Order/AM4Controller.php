<?php

namespace App\Http\Controllers\Order;

use App\Order\AM4;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AM4Controller extends Controller
{
    public function fetch(Request $request)
    {
        $goods_add_ons = AM4::query();

        if ($request->get("id") != "undefined") {
            $goods_add_ons->where("id", $request->get("id"));
        }

        if ($request->get("name") != "undefined") {
            $goods_add_ons->where("name", $request->get("name"));
        }

        return $goods_add_ons->get();
    }
}
