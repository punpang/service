<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\ProductAddOn;

class ProductAddOnController extends Controller
{
    public function fetchAddOn(Request $request)
    {
        // dd(request()->all());
        // dd($request);
        $producAddOn = ProductAddOn::query();
        if ($request->get("name")) {
            $producAddOn->whereHas("goodsAddOn", function ($query) use ($request) {
                $query->where("name", "like", "%" . $request->get("name") . "%");
            });
        }

        if ($request->get("am4")) {
            $producAddOn->where("am4_id", $request->get("am4"));
        }

        return $producAddOn->with("goodsAddOn")->get();
    }
}
