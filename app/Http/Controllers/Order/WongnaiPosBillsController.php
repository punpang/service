<?php

namespace App\Http\Controllers\Order;

use App\MSms;
use App\Helper;
use App\Linenotify;
use App\Order\Facebook;
use App\Order\ShotlinkV2;
use App\Order\CustomerScore;
use Illuminate\Http\Request;
use App\Order\WongnaiPosBills;
use Google\Service\Compute\Help;
use App\Order\RegisterMemberTemp;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Order\RegisterWongnaiPosBill;
use App\Imports\WongnaiPosBillsImport;

// use Maatwebsite\Excel\Excel;

class WongnaiPosBillsController extends Controller
{
    public function import()
    {
        Excel::import(new WongnaiPosBillsImport, request()->file('file'));
    }

    public function test()
    {
        $null_register_bills = RegisterWongnaiPosBill::whereNull("customer_score_id")->get();

        foreach ($null_register_bills as $null_register_bill) {
            $wongnai_pos_bill =  WongnaiPosBills::where("bill_id", $null_register_bill->bill_id)
                ->whereIn("payment_type", ["Cash", "โอนเงิน", "E-Payment", "UnionPay"])
                ->first();
            if ($wongnai_pos_bill) {
                if ($wongnai_pos_bill->payment_date_time > $null_register_bill->created_at) {
                    // return $wongnai_pos_bill;
                    // $score = "";
                    switch ($wongnai_pos_bill->order_type) {
                        case 'Dine-In':
                            $score = CustomerScore::addScore($null_register_bill->facebook->customer, $wongnai_pos_bill->total);
                            break;
                        case 'Delivery':
                            if ($wongnai_pos_bill->payment_type == "E-Payment") {
                                $amount = $wongnai_pos_bill->total * 65 / 100;
                            } else {
                                $amount = $wongnai_pos_bill->total;
                            }
                            $score = CustomerScore::addScore($null_register_bill->facebook->customer, $amount);
                            break;
                        default:
                            # code...
                            break;
                    }
                    // return $score;
                    if ($score["status"] == "success") {
                        $null_register_bill->update([
                            "customer_score_id" => $score["score"]["id"]
                        ]);
                        AlertMessages::smsAddScore($customer, $score->point);
                    }
                } else {
                    $null_register_bill->delete();
                }
            }
        }
    }

    public function set_url_timeout()
    {
        $url =  URL::temporarySignedRoute(
            'profile_psid',
            now()->addMinutes(5),
            ["psid" => "5143259939075665"]
        );

        return Helper::get_params_url($url);
        // $parse_url = parse_url($url);
        // $params = [];
        // $ex1 = explode("&", $parse_url["query"]);

        // foreach ($ex1 as $ex2) {
        //     $ex3 = explode("=", $ex2);
        //     $params[$ex3[0]] = $ex3[1];
        // }
        // dd($params);
    }

    public function url_set_time(Request $request)
    {

        if ($request->check_expires) {
            return;
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
