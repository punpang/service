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
                $data = APrice::whereCode($op)->with("am1:id,m1", "am2:id,m2", "am3:id,m3", "am4:id,m4", "googleImage:id,src_name")->first();
            }

            DB::commit();

            return $data;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function fetchOption()
    {
        $am1 = AM1::orderBy("sort", "ASC")->get();
        $am2 = AM2::orderBy("sort", "ASC")->get();
        $am3 = AM3::orderBy("sort", "ASC")->get();
        $am4 = AM4::orderBy("sort", "ASC")->get();

        // foreach ($am4 as $a) {
        //     $a->setAppends(["name"]);
        // }

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

    public function update_sort(Request $request)
    {
        foreach ($request->sort as $sort) {
            DB::table($request->option)
                ->where('id', $sort["id"])
                ->update(["sort" => $sort["sort"]]);
        }
        return response()->json([], 200);
    }

    public function add_option(Request $request)
    {
        switch ($request->option_id) {
            case '1':
                $db = AM1::create(["m1" => $request->text]);
                $db->update(["sort" => $db->id]);
                break;

            case '2':
                $db = AM2::create(["m2" => $request->text]);
                $db->update(["sort" => $db->id]);
                break;

            case '3':
                $db = AM3::create(["m3" => $request->text]);
                $db->update(["sort" => $db->id]);
                break;

            case '4':
                $db = AM4::create(["m4" => $request->text]);
                $db->update(["sort" => $db->id]);
                break;

            default:
                # code...
                break;
        }

        return response()->json([], 200);
    }

    public function edit_option(Request $request)
    {
        switch ($request->option_id) {
            case '1':
                AM1::where("id", $request->text_id)->update(["m1" => $request->text]);
                break;

            case '2':
                AM2::where("id", $request->text_id)->update(["m2" => $request->text]);
                break;

            case '3':
                AM3::where("id", $request->text_id)->update(["m3" => $request->text]);
                break;

            case '4':
                AM4::where("id", $request->text_id)->update(["m4" => $request->text]);
                break;

            default:
                # code...
                break;
        }

        return response()->json([], 200);
    }

    public function fetch_options($option)
    {
        $db = DB::table("a_m" . $option)->orderBy("sort", "ASC")->get();

        return response()->json([
            "options" => $db
        ], 200);
    }

    public function up_a_price()
    {
        $products = APrice::get();
        foreach ($products as $product) {
            if ($product->updated_at < "2024-06-19 00:00:00") {
                // return $product;
                $p = (int)($product->price * 1.07);
                $p = strval($p);
                $cp = strlen($p);
                if ($p[$cp - 1] != 0) {
                    $p[$cp - 1] = 0;
                    $p = $p + 10;
                }

                $product->price = (int)$p;
                // $product->price = $product->price - 9;
                $product->update();
                // return $product;
            }
        }

        return $products;
    }
}
