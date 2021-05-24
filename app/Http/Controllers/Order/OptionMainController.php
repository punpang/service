<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OptionMain;

class OptionMainController extends Controller
{
    public function productCheck($product_id)
    {
        $data = OptionMain::whereOp1($product_id)->first();

        if ($data == null) {
            $status = false;
        } else {
            $status = true;
        }

        return response()->json($status, 200);
    }

    public function check($product_id, $subs1)
    {
        $data = OptionMain::whereOp2($subs1)->whereProductId($product_id)->with("sub")->with("sub.ProductCategorySub")->first();


        if ($data == null) {
            return response()->json([
                "status" => false
            ], 200);
        } else {
            return response()->json([
                "data" => $data,
                "status" => true
            ], 200);
        }
    }

    public function checkOP2($product_id, $subs1)
    {
        $data = OptionMain::whereOp2($subs1)->whereProductId($product_id)->with("sub")->with("sub.ProductCategorySub")->first();

        if ($data == null) {
            $status = false;
        } else {
            $status = true;
        }

        return response()->json($status, 200);
    }

    public function store()
    {
        //dd(request()->all());
        if (request("op1")) {
            $subs1 = request("op1");
            $product_category_id = request("product_category_id");
        } else {
            $subs1 = request("subs1");
            $product_category_id = request("product_id");
        }

        OptionMain::whereId(request("op1"))->update(["product_category_id" => $product_category_id]);
        OptionMain::whereOp1($subs1)->whereProductId(request("product_id"))->update(["status" => 0]);

        foreach (request("subs2") as $op2) {
            $find = OptionMain::whereOp1($subs1)
                ->whereOp2($op2)
                ->whereProductId(request("product_id"))
                ->update(["status" => 1]);

            if ($find == 0) {
                $data = new OptionMain;
                $data->op1 = $subs1;
                $data->op2 = $op2;
                $data->product_id = request("product_id");
                $data->product_category_id = $product_category_id;
                $data->status = 1;
                $data->save();
            }
        }

        $newData = OptionMain::whereOp1($subs1)->whereProductId(request("product_id"))->get();

        return response()->json($newData, 200);
    }
}
