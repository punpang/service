<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Linenotify;
use App\MSms;
use App\Order\RewardCustomer;
use App\Order\RewardLabel;
use Illuminate\Support\Str;
use Bitly;
use App\URL;

class RewardController extends Controller
{
    public function getOTP()
    {
        $message = "ปั้นแป้ง สวัสดีค่ะ รหัส OTP ของคุณ คือ " . request("random_otp") . " โปรดเก็บเป็นความลับ ขอบพระคุณค่ะ";
        $sms = MSms::Sms(request("phone"), $message);
        // Linenotify::send("ลูกค้าแจ้งชำระเงิน");
        return $sms;
    }

    public function register()
    {
        $customer = request("customers");
        $nors = request("number_of_right");

        // ค้นหาสมาชิก สร้างใหม่ และเปลี่ยนชื่อลูกค้าทุกครั้ง
        $findCustomer = RewardCustomer::CustomerAddEdit($customer["name"], $customer["phone"]);

        // ลงทะเบียนสิทธิ์ตามลำดับ
        RewardLabel::rewardRegister($nors, $findCustomer->id);

        // นับจำนวนรางวัลคงเหลือ ตามกลุ่ม และแจ้งผ่าน line
        RewardLabel::rewardCountByGroup();

        //สร้างลิงก์ให้ลูกค้า และส่ง SMS ไปยังลูกค้า เพื่อลุ้นรางวัล
        $link = URL::base() . "/lucky/reward/" . $findCustomer->uuid;
        $bitly = Bitly::getUrl($link);
        $message = "ปั้นแป้ง สวัสดีค่ะ คลิกลิงก์ [ " . $bitly . " ] เพื่อลุ้นรางวัลได้เลยค่ะ ห้ามส่งต่อลิงก์ให้บุคคลอื่น";
        MSms::Sms($findCustomer->phone, $message);

        return response()->json(
            [
                "success" => true,
                "message" => "ลงทะเบียนเรียบร้อย"
            ],
            200
        );
    }
}
