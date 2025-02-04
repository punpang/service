<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Sms;
use App\Linenotify;
use App\FacebookMessager;
use App\SendSmsAgain;

class MSms extends Model
{

    public static function Sms($p, $m, $allow = true)
    {
        if ($allow) {

            $key = MSms::LCKEY();
            $MSms = MSms::LCSms($p, $m, $key);
            if ($MSms['status'] == 200) {
                return [
                    'success' => true,
                    'message' => 'ส่ง SMS สำเร็จ'
                ];

                // return response()->json([
                //     'success' => true,
                //     'message' => 'ส่ง SMS สำเร็จ'
                // ], 200);
            } elseif ($MSms['status'] == 400) {
                (new Linenotify)->line('แจ้งเตือน : ระบบ SMS ไม่ทำงาน กรุณาเปิดปิดแอพใหม่ !');

                SendSmsAgain::firstOrCreate([
                    "phone" => $p,
                    "message" => $m
                ]);

                return [
                    'success' => false,
                    'message' => 'ส่ง SMS ไม่สำเร็จ'
                ];
                // $sms = Sms::send($p,$m);
                // if ($sms != 200) {
                //   // return 400;
                //   return $sms['code'];
                // }
            }
        } else {
            return [
                'success' => true,
                'message' => 'ไม่ต้องส่ง SMS'
            ];
        }
    }

    public static function SMSV2($number, $message, $key)
    {
        $message_encode = json_encode($message);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.1.159:8082',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
        "to": "' . $number . '",
        "message": "' . $message_encode . '"
    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: ceb23a6e'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return [
                "status" => 400,
                "response" => $err
            ];
        } else {
            return [
                "status" => 200,
                "response" => $response
            ];
        }
    }

    public static function SMSFB($order, $message, $allow = true) // order , message , allow
    {
        MSms::Sms($order->customer->phone, $message, $allow);
        FacebookMessager::postMessage($order->customer, $order->ChannelOfPurchase->name, $message, $allow);
    }

    public static function LCURL()
    {
        return config('message.LCSms.url');
    }

    public static function LCKEY()
    {
        return config('message.LCSms.key');
    }

    public static function LCSms($number, $message, $key)
    {
        // dd($number,$message,$key,MSms::LCURL());
        if ($key == MSms::LCKEY()) {

            $url = MSms::LCURL();
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => "",
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\t\"number\":\"$number\",\n\t\"text\":\"$message\"\n\t\n}",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json; charset=utf-8",
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return [
                    "status" => 400,
                    "response" => $err
                ];
            } else {
                return [
                    "status" => 200,
                    "response" => $response
                ];
            }
        }
    }
}
