<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\APrice;
use App\Order\AM1;
use App\Order\AM2;
use App\Order\AM3;
use App\Order\AM4;
use Illuminate\Support\Facades\DB;

class APriceController extends Controller
{
    public function fetchPriceOfCake()
    {
        DB::beginTransaction();

        try {


            $op = request('op1') . request('op2') . request('op3') . request('op4');
            $data = APrice::whereCode($op)->with("googleImage")->first();

            if ($data) {
                if ($data->m1 == 0) {
                    $data->m1 = request('op1');
                    $data->m2 = request('op2');
                    $data->m3 = request('op3');
                    $data->m4 = request('op4');
                    $data->save();
                }
                $data = APrice::whereCode($op)->with("am1", "am2", "am3", "am4", "googleImage")->first();
            }

            DB::commit();

            return $data;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function fetchOption()
    {
        $am1 = AM1::get();
        $am2 = AM2::get();
        $am3 = AM3::get();
        $am4 = AM4::get();

        return [
            "op1" => $am1,
            "op2" => $am2,
            "op3" => $am3,
            "op4" => $am4
        ];
    }

    public function editPrice(APrice $product)
    {
        DB::beginTransaction();
        try {

            if ($product->price != request("price")) {
                $product->price = request("price");
                $product->save();
            }
            DB::commit();

            return "success";
        } catch (\Exception $err) {
            DB::rollback();
            return "error";
        }

        dd(request("price"));
        // $product->price = request("");
    }

    public function addPrice()
    {
        DB::beginTransaction();

        try {
            $op = request('ops.op1') . request('ops.op2') . request('ops.op3') . request('ops.op4');

            $data = new APrice;
            $data->code = $op;
            $data->price = request('price');
            $data->m1 = request('ops.op1');
            $data->m2 = request('ops.op2');
            $data->m3 = request('ops.op3');
            $data->m4 = request('ops.op4');
            $data->save();

            DB::commit();

            return "success";
        } catch (\Exception $err) {
            DB::rollback();
            return "error";
        }
    }

    public function uploadImageProduct(APrice $product, Request $request)
    {
        // dd($product->with("googleImage"));
        $product->update([
            "image_id" => $request->images[0]["id"],
        ]);


        $product_like = $product->m1 . $product->m2 . $product->m3;

        $am4 = AM4::get();

        foreach ($am4 as $a) {
            APrice::where("code", $product_like . $a->id)->update([
                "image_id" => $request->images[0]["id"],
            ]);
        }
        
        $product = APrice::with("googleImage")->find($product->id);

        return response()->json([
            "product" => $product,
            "status" => "success",
            "title" => "สำเร็จ",
            "text" => "อัปโหลดสำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
