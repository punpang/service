<?php

namespace App\Http\Controllers\Order;

use App\MSms;
use App\Pos\Goods;
use Carbon\Carbon;
use App\Order\ACustomer;
use Illuminate\Http\Request;
use App\Order\ProductInterest;
use App\Http\Controllers\Controller;

class ProductInterestController extends Controller
{
    public function store(Request $request)
    {
        $customer = ACustomer::firstOrCreate(
            ["tel" => $request->phone_number],
            [
                "name" => "ลูกค้า",
                "social" => 0,
                "social_is" => ""
            ]
        );

        // dd($request->goods);

        foreach ($request->goods as $goods) {
            // dd($goods["id"]);
            ProductInterest::firstOrCreate([
                "customer_id" => $customer->id,
                "pos_goods_id" => $goods["id"],
                "status_sms_alert" => 0
            ]);

            $count = ProductInterest::where(
                "pos_goods_id",
                $goods["id"],
            )
                ->where("status_sms_alert", 0)
                ->count();

            Goods::where("id", $goods["id"])
                ->update(["count_product_interest" => $count]);
        }

        return response()->json([
            "title" => "ลงทะเบียนสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function fetch()
    {
        $goods = Goods::where("count_product_interest", ">", 0)->orderBy("count_product_interest", "DESC")->get();
        return response()->json([
            "title" => "โหลดข้อมูลสำเร็จ",
            "icon" => "success",
            "goods" => $goods
        ], 200);
    }

    public function alert_to_customer(Goods $goods)
    {
        $productInterests = $goods->productInterests->where("status_sms_alert", 0);
        $date = Carbon::now()->addYears(543)->format('d-m-Y');


        foreach ($productInterests as $productInterest) {
            $msgSms = "ปั้นแป้ง สวัสดีค่ะ วันนี้ ($date) [ $goods->text ] มีสินค้าพร้อมจำหน่ายนะคะ";

            $result_sms = MSms::Sms($productInterest->customer->tel, $msgSms, true);
            if ($result_sms["success"] == false) {
                return response()->json([
                    "title" => "ส่งข้อความไม่สำเร็จ",
                    "icon" => "error",
                    "text" =>  "ระบบ SMS ไม่ทำงาน",
                ], 200);
            }

            $productInterest->update(["status_sms_alert" => 1]);
        }

        $goods->update(["count_product_interest" => 0]);

        return response()->json([
            "title" => "ส่งข้อความสำเร็จ",
            "icon" => "success",
        ], 200);
    }
}
