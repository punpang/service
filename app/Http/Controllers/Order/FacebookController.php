<?php

namespace App\Http\Controllers\Order;

use App\Linenotify;
use App\Order\Setting;
use App\Order\Facebook;
use App\Order\FacebookMids;
use Illuminate\Http\Request;
use App\Order\FacebookWebhook;
use App\Http\Controllers\Controller;

class FacebookController extends Controller
{
    public function webhook(Request $request)
    {
        Linenotify::send("Facebook Status Bot :: TEST");

        $setting = Setting::first();
        if (!$setting->facebook_status_bot || $request->method() == "GET") {
            Linenotify::send("Facebook Status Bot :: Start Off");
            Linenotify::send($request->getContent());
            Linenotify::send("Facebook Status Bot :: End Off");
            return $request["hub_challenge"];
        }

        $input = json_decode($request->getContent(), true);

        // PSID ของลูกค้า
        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];

        // สร้างโปรไฟล์ลูกค้า สำหรับผูกสมาชิกต่อไป และอัปเดทคุยล่าสุด
        $profile = Facebook::create_profile($sender);

        // ตรวจสอบว่าทักครั้งแรกหรือไม่
        if ($profile->welcome_date != now()->format('Y-m-d')) {
            Facebook::welcome_date($profile);
        }

        // นอกเวลาทำการ
        if (
            now()->format("H:i") >= $setting->close_store ||
            now()->format("H:i") <= $setting->open_store
        ) {
            $message_out = "ขณะนี้ ! อยู่นอกเวลาทำการ โปรดติดต่ออีกครั้งในช่วงเวลาทำการ ($setting->open_store - $setting->close_store น.) ขออภัยในความไม่สะดวก

        **ทุกข้อความตอบกลับโดยระบบอัตโนมัติ";
            Facebook::reply_message_v2($sender, $message_out);
            return $request["hub_challenge"];
        }

        // มีข้อความไหม --เป็นตัวหนังสือ--
        if (!empty($input['entry'][0]['messaging'][0]['message']['text'])) {
            if (FacebookMids::check($input['entry'][0]['messaging'][0]['message']['mid'])) {
                return $request["hub_challenge"];
            }
            $message = $input['entry'][0]['messaging'][0]['message']['text'];

            // สมัครสมาชิก
            // if (
            //     str_starts_with($message, "สมัครสมาชิก") &&
            //     Facebook::register_member($sender, $message)
            // ) {
            //     return $request["hub_challenge"];
            // }

            // สร้างคำที่ยังไม่มีในฐานข้อมูล พร้อมดึงข้อมูลออกมา
            $FacebookWebhook = FacebookWebhook::firstOrCreate([
                "message" => $message,
            ]);

            // ตอบข้อความที่ตรงกับฐานข้อมูล
            if ($FacebookWebhook->reply) {
                Facebook::reply_message_v2($sender, $FacebookWebhook->reply->text_th);
            }

            // ตอบคะแนนของลูกค้า
            // if ($message == "คะแนนของฉัน") {
            //     Facebook::sumCustomerScore($profile, $sender);
            //     // return $request["hub_challenge"];
            // }
        }

        // มี POSTBACK
        // if (!empty($input['entry'][0]['messaging'][0]['postback']['payload'])) {
        //     $postback = json_decode($input['entry'][0]['messaging'][0]['postback']['payload'], true);
        //     Facebook::key_word_postback($sender, $postback);
        // }

        return $request["hub_challenge"];
    }

    public function search_profile(Request $request)
    {
        $datas = Facebook::query();

        if ($request->get("name") != "undefined") {
            $explodeName = explode(" ", $request->get("name"));
            if (!isset($explodeName[1])) {
                $datas->where("first_name", "like",  '%' . $explodeName[0] . '%')
                    ->orWhere("last_name", "like",  '%' . $explodeName[0] . '%');
                // $datas->where("last_name", "like",  '%' . $explodeName[0] . '%');
            } else {
                $datas->where("first_name", "like",  '%' . $explodeName[0] . '%')
                    ->orWhere("last_name", "like",  '%' . $explodeName[1] . '%');
            }
        }

        if ($request->get("isNullCustomer") != "undefined") {
            if ($request->get("isNullCustomer") == true) {
                $datas->whereNull("customer_id");
            }
        }

        return $datas->get();
    }

    public function connect_profile(Facebook $profile, Request $request)
    {
        $count = Facebook::where("customer_id", $request->customer_id)->count();
        if ($count != 0) {
            return response()->json([
                "status" => "failed",
                "title" => "ไม่สำเร็จ",
                "icon" => "error"
            ], 200);
        }

        $profile->update([
            "customer_id" => $request->customer_id
        ]);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function disconnect_profile(Facebook $profile, Request $request)
    {
        if ($profile->customer->id == $request->customer_id) {
            $profile->update([
                "customer_id" => NULL
            ]);
        }

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
