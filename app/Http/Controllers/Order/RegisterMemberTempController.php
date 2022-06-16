<?php

namespace App\Http\Controllers\Order;

use App\MSms;
use App\Order\Line;
use App\Order\Facebook;
use App\Order\ACustomer;
use Illuminate\Http\Request;
use App\Order\RegisterMemberTemp;
use App\Http\Controllers\Controller;


class RegisterMemberTempController extends Controller
{
    public function update(Request $request)
    {
        RegisterMemberTemp::where("expiration_date", "<", now()->format("Y-m-d H:i:s"))
            ->delete();

        $temp = RegisterMemberTemp::where("token", $request->get("token"))
            ->where("expiration_date", ">", now()->format("Y-m-d H:i:s"))
            ->first();

        if (!$temp) {
            return response()->json([
                "status" => "error",
                "title" => "ล้มเหลว",
                "icon" => "error",
                "text" => "ลิงก์ยืนยันหมดอายุ โปรดสมัครใหม่อีกครั้ง"
            ], 200);
        }

        $customer = ACustomer::updateOrCreate(["tel" => $temp->phone], [
            "name" => $temp->name,
            "social" => "0",
            "social_is" => "-"
        ]);

        if ($temp->channel == "facebook") {
            Facebook::where("customer_id", $customer->id)->update(["customer_id" => NULL]);
            Facebook::where("psid", $temp->psid_userId)->update(["customer_id" => $customer->id]);
        } else if ($temp->channel == "line") {
            Line::where("customer_id", $customer->id)->update(["customer_id" => NULL]);
            Line::where("userId", $temp->psid_userId)->update(["customer_id" => $customer->id]);
        }

        $temp->delete();

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success",
            "text" => "สมัครสมาชิกเรียบร้อย"
        ], 200);
    }
}
