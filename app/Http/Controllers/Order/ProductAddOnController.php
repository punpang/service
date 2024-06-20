<?php

namespace App\Http\Controllers\Order;

use App\Order\ProductAddOn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function fetch(Request $request)
    {
        $product_add_on = ProductAddOn::query();

        if ($request->get("goods_add_on_id") != "undefined") {
            $product_add_on->where("goods_add_on_id", $request->get("goods_add_on_id"));
        }

        if ($request->get("am4_id") != "undefined") {
            $product_add_on->where("am4_id", $request->get("am4_id"));
        }

        if ($request->get("isFirst") != "undefined" && $request->get("isFirst")) {
            return $product_add_on->first();
        } else {
            return $product_add_on->get();
        }
    }

    public function create(Request $request)
    {
        ProductAddOn::updateOrCreate(
            [
                "goods_add_on_id" => $request->goods_add_on["id"],
                "am4_id" => $request->m4,

            ],
            [
                "price" => $request->price
            ]
        );

        return  response()->json([
            "status" => "success"
        ], 200);
    }

    public function up_price_product_add_on()
    {
        $products = ProductAddOn::get();
        foreach ($products as $product) {
            $p = (int)($product->price * 1.07);
            $p = strval($p);
            $cp = strlen($p);

            if ($p[$cp - 1] >= 1 && $p[$cp - 1] <= 5) {
                $p[$cp - 1] = 5;
            } else if ($p[$cp - 1] >= 6 && $p[$cp - 1] <= 9) {
                $p[$cp - 1] = 0;
                $p = $p + 10;
            }

            // $product->price_vat_up = (int)$p;
            // $product->price_vat = $product->price * 1.07;
            $product->price = (int)$p;
            $product->update();
        }

        return $products;
    }

    public function up_price_product_add_on_discount()
    {
        $products = ProductAddOn::where("price", "<", 0)->get();
        foreach ($products as $product) {
            if ($product->updated_at < "2024-06-20 12:48:00") {
                $product->price = $product->price - 20;
                $product->update();
            }
        }

        return $products;
    }
}
