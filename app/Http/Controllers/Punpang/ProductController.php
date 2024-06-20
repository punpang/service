<?php

namespace App\Http\Controllers\Punpang;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Punpang\Product;

class ProductController extends Controller
{
    public function fetchAllUse()
    {
        $data = Product::with("prices.size", "productDetail")->orderBy("type", "asc")->get();

        return response()->json($data, 200);
    }

    public function up_price_goods_normal()
    {
        $products = Product::with("prices")->get();

        foreach ($products as $product) {
            foreach ($product->prices as $price) {
                $p = (int)($price->price * 1.07);
                $p = strval($p);
                $cp = strlen($p);
                if ($p[$cp - 1] != 0) {
                    $p[$cp - 1] = 0;
                    $p = $p + 10;
                }
                $price->price = (int)$p;

                $pn = (int)($price->price_normal * 1.07);
                $pn = strval($pn);
                $cpn = strlen($pn);
                $pn[$cpn - 1] = 0;
                $pn = $pn + 10;
                $price->price_normal = (int)$pn;

                $price->update();
            }
        }
        return $products;
    }
}
