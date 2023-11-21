<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\Order\Coupons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CouponsController extends Controller
{
    public function fetch(Request $request)
    {
        $query = Coupons::query();

        if ($request->get("sortByDateStart") != null) {
            $query->orderBy("date_start", $request->get("sortByDateStart"));
        }

        // if ($request->get("with") != null) {
        //     $explodes = explode(",", $request->get("with"));
        //     foreach ($explodes as $e) {
        //         $query->with($e);
        //     }
        // }

        return response()->json([
            "coupons" => $query->get(),
            "title" => "โหลดข้อมูลสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function store(Request $request)
    {
        if ($request->date_start > $request->date_end) {
            return response()->json([
                "icon" => "error",
                "title" => "วันที่เริ่มต้น ต้องน้อยกว่า วันที่สิ้นสุด"
            ], 200);
        }

        $code = bin2hex(openssl_random_pseudo_bytes(5));

        $find = Coupons::where("code", $code)->first();
        if ($find) {
            return response()->json([
                "icon" => "warning",
                "title" => "กรุณากดบันทึกใหม่อีกครั้ง เนื่องจากโค้ดคูปองซ้ำ",

            ], 201);
        }

        $data = Coupons::create([
            "title" => $request->title,
            "code" => bin2hex(openssl_random_pseudo_bytes(5)),
            "minimum" => $request->minimum,
            "maximum" => $request->maximum,
            "percent" => $request->percent,
            "date_start" => $request->date_start,
            "date_end" => $request->date_end,
            "limit_times" => $request->limit_times,
            "customer_id" => $request->customer_id,
            "remark" => $request->remark
        ]);

        return response()->json([
            "icon" => "success",
            "title" => "ทำรายการสำเร็จ",
            "text" => "สร้างคูปองสำเร็จ"
        ], 200);
    }

    public function update(Coupons $id, Request $request)
    {
        if ($request->date_start > $request->date_end) {
            return response()->json([
                "icon" => "error",
                "title" => "วันที่เริ่มต้น ต้องน้อยกว่า วันที่สิ้นสุด"
            ], 200);
        }

        $id->update([
            "title" => $request->title,
            "minimum" => $request->minimum,
            "maximum" => $request->maximum,
            "percent" => $request->percent,
            "date_start" => $request->date_start,
            "date_end" => $request->date_end,
            "limit_times" => $request->limit_times,
            "customer_id" => $request->customer_id,
            "remark" => $request->remark
        ]);

        return response()->json([
            "icon" => "success",
            "title" => "ทำรายการสำเร็จ",
            "text" => "แก้ไขคูปองสำเร็จ"
        ], 200);
    }

    public function use_coupon(Coupons $id, Request $request)
    {
        $code = "";
        $sum_price = 10;
        $customer_id = 1;

        $find = Coupons::where("code", $code)->first();

        if (!$find) {
            return "ไม่พบคูปอง";
        }

        if ($find->minimum > $sum_price) {
            // 50 > 10
            return "ไม่ถึงยอดขั้นต่ำ";
        }

        if ($find->limit_times < $find->used_times) {
            //100 < 101
            return "คูปองนี้ ถูกใช้เต็มจำนวนแล้ว";
        }

        $now = Carbon::now()->format("Y-m-d");
        if ($find->date_start < $now) {
            // 30/05/66 < 30/05/66      F
            // 29/05/66 < 30/05/66      T
            // 31/05/66 < 30/05/66      F
            return "คูปองนี้ ยังไม่ถึงวันที่เริ่มต้นใช้งาน";
        }

        if ($find->date_end > $now) {
            // 29/05/66 > 30/05/66     F
            // 30/05/66 > 30/05/66     F            
            // 31/05/66 > 30/05/66     T
            return "คูปองนี้ วันใช้งานสิ้นสุดแล้ว";
        }

        if ($find->customer_id != null) {
            if ($find->customer_id != $customer_id) {
                return "คูปองนี้ ใช้ได้เฉพาะลูกค้าที่กำหนดไว้";
            }
        }

        $discount = $sum_price * $find->percent / 100;
        $discount = $discount >= $find->maximum ? $find->maximum : $discount;

        
    }
}
