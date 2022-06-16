<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\RewardCustomer;
use App\Order\RewardLabel;
use App\MSms;
use App\Linenotify;

class RewardLabelController extends Controller
{
    public function openReward()
    {
        // ตรวจสอบ สมาชิกถูกต้องหรือไม่
        $customer = RewardCustomer::whereId(request("reward_customer_id"))
            ->whereUuid(request("uuid"))->first();

        // ไม่ถูกต้องให้ตอบกลับ
        if (is_null($customer)) {
            return response()->json(
                [
                    "message" => "ข้อมูลไม่ถูกต้อง",
                    "error" => true
                ],
                201
            );
        }

        $reward_label = RewardLabel::where(
            ["id" => request("reward_label_id")],
            ["reward_customer_id" => request("reward_customer_id")],
            ["reward_id" => request("reward_id")]
        )->update(["status_open" => 1]);

        return response()->json([
            "success" => true,
        ], 200);
    }

    public function getRedeemCode()
    {

        // ตรวจสอบ สมาชิกถูกต้องหรือไม่
        $customer = RewardCustomer::checkByIdUuid(request("reward_customer_id"), request("uuid"));

        // ไม่ถูกต้องให้ตอบกลับ
        if (is_null($customer)) {
            return response()->json(
                [
                    "message" => "ข้อมูลไม่ถูกต้อง",
                    "error" => true
                ],
                201
            );
        }



        $reward_label = RewardLabel::where("id", request("reward_label_id"))
            ->where("reward_customer_id", request("reward_customer_id"))
            ->where("reward_id", request("reward_id"))
            ->where("status_use_redeem_code", 0)
            ->where("status_open", 1)
            ->first();

        // ไม่ถูกต้องให้ตอบกลับ
        if (is_null($reward_label)) {
            return response()->json(
                [
                    "message" => "คุณแลกรางวัลไปแล้ว",
                    "error" => true
                ],
                201
            );
        }

        $reward_label->redeem_code = rand(1000000000, 9999999999);
        $reward_label->update();

        $msgLine = "กดแลกรหัส -> " . $customer;
        Linenotify::send($msgLine);

        $msgSms = "ปั้นแป้ง สวัสดีค่ะ รหัสลับ Redeem Code ของคุณ คือ [ " . $reward_label->redeem_code . " ] โปรดเก็บเป็นความลับเฉพาะคุณ (รหัสลับมีอายุ 5 นาที)";
        MSms::Sms($customer->phone, $msgSms);

        return response()->json([
            "success" => true,
            "message" => "รหัสลับของคุณได้ส่งไปยัง SMS เรียบร้อย โปรดแจ้งเบอร์โทรและรหัสลับ Redeem Code แก่พนักงาน เพื่อแลกรางวัล"
        ], 200);
    }
}
