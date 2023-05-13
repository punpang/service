<?php

namespace App\Http\Controllers\Order;

use App\MSms;
use App\Order\Line;
use App\Order\Facebook;
use App\Order\ACustomer;
use App\Order\ShotlinkV2;
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

    public function register_member_by_facebook(Request $request)
    {
        if ($request->check_expires) {
            $customer = Facebook::where("psid",$request->get("psid"))
            ->with("customer:id,tel,name")
            ->first();
            return $customer;
        }

        $request->validate([
            "name" => "required",
            "phone" => "required|numeric|digits_between:10,10|starts_with:0",
        ], [
            "name.required" => "ห้ามว่าง",
            "phone.starts_with" => "ต้องเริ่มต้นด้วย 0"

        ]);

        // return $request->name;

        $temp = RegisterMemberTemp::updateOrCreate(
            ["psid_userId" => $request->get("psid")],
            [
                "name" => $request->name,
                "phone" => $request->phone,
                "token" => bin2hex(openssl_random_pseudo_bytes(32)),
                "channel" => "facebook",
                "expiration_date" => now()->addMinutes("15")->format("Y-m-d H:i:s")
            ]
        );

        $link = ShotlinkV2::store("/verify_identity/register_member/" . $temp->token, 1);
        MSms::Sms($temp->phone, "คลิกลิงก์ [ " . $link . " ] เพื่อยืนยันการสมัครสมาชิก โปรดทำรายการภายใน 15 นาที");
        // Facebook::reply_message_v2($request->get("psid"), "ระบบได้ส่งลิงก์สำหรับยืนยันตัวตนไปยัง SMS ตามหมายเลขที่ท่านแจ้งไว้ โปรดยืนยันภายใน 15 นาที");

        return [
            // "data" => $temp,
            "status" => "success",
            "title" => "สมัครสมาชิกแล้ว",
            "text" => "ระบบได้ส่งลิงก์สำหรับยืนยันตัวตนไปยัง SMS ตามหมายเลขที่ท่านแจ้งไว้ โปรดยืนยันภายใน 15 นาที",
            "icon" => "success"
        ];
    }
}
