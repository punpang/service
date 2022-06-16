<?php

namespace App\Http\Controllers\Order;

use App\Linenotify;
use App\Order\Line;
use App\Order\Setting;
use App\Order\Facebook;
use Illuminate\Http\Request;
use App\Order\FacebookWebhook;
use App\Http\Controllers\Controller;

class LineController extends Controller
{
    public function webhook(Request $request)
    {
        $setting = Setting::first();
        if (!$setting->line_status_bot) {
            Linenotify::send("Line Status Bot :: Off");
            return;
        }

        $response = json_decode($request->getContent(), true);

        if ($response["events"][0]["deliveryContext"]["isRedelivery"]) {
            return response()->json([], 200);
        }

        $userId = $response["events"][0]["source"]["userId"];
        $replyToken = $response["events"][0]["replyToken"];

        $profile = Line::create_profile($userId);

        if (
            now()->format("H:i") >= $setting->close_store ||
            now()->format("H:i") <= $setting->open_store
        ) {
            $message_out = "ขณะนี้ ! อยู่นอกเวลาทำการ โปรดติดต่ออีกครั้งในช่วงเวลาทำการ ($setting->open_store - $setting->close_store น.) ขออภัยในความไม่สะดวก

**ทุกข้อความตอบกลับโดยระบบอัตโนมัติ";
            Line::reply_message_v2($replyToken, $message_out);
        }


        if ($response["events"][0]["type"] == "message") {
            if ($response["events"][0]["message"]["type"] == "text") {
                $text = $response["events"][0]["message"]["text"];

                Line::register_member($replyToken, $userId, $text);

                // สร้างคำที่ยังไม่มีในฐานข้อมูล พร้อมดึงข้อมูลออกมา
                $webhook = FacebookWebhook::firstOrCreate([
                    "message" => $text,
                ]);

                // ตอบคะแนนของลูกค้า
                if ($text == "คะแนนของฉัน") {
                    Line::sumCustomerScore($profile, $replyToken);
                }

                // ตอบข้อความที่ตรงกับฐานข้อมูล
                if ($webhook->reply) {
                    Line::reply_message_v2($replyToken, $webhook->reply->text_th);
                    $messages[] = $webhook->reply->text_th;
                }
            }

            if ($response["events"][0]["message"]["type"] == "location") {
                $latitude = $response["events"][0]["message"]["latitude"];
                $longitude = $response["events"][0]["message"]["longitude"];
                $location = "https://www.google.com/maps/place/" . $latitude . "N+" . $longitude . "E";
                Linenotify::send("แจ้งตำแหน่งจัดส่งของ คุณ " . $profile->displayName . " || " . $location);
            }
        }

        if ($response["events"][0]["type"] == "postback") {
            $postback = json_decode($response["events"][0]["postback"]["data"], true);
            Line::key_word_postback($replyToken, $postback);
        }

        // นอกเวลาทำการ

        return response()->json([], 200);
    }

    public function search(Request $request)
    {
        $datas = Line::query();

        if ($request->get("displayName") != "undefined") {
            $datas->where("displayName", "like",  '%' . $request->get("displayName") . '%');
        }

        if ($request->get("isNullCustomer") != "undefined") {
            if ($request->get("isNullCustomer") == true) {
                $datas->whereNull("customer_id");
            }
        }

        return $datas->get();
    }

    public function connect_profile(Line $profile, Request $request)
    {
        $count = Line::where("customer_id", $request->customer_id)->count();

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

    public function disconnect_profile(Line $profile, Request $request)
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
