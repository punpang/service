<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Linenotify;

class Sms extends Model
{
    public static function send($phone_number,$message)
    {
        $Authorization = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0NzM3NzMxOSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjUyOTgyLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.rQU3q0NZ0beTn9W0h1IFkU4Aqra__5cgASM7rYBOBvY";
        $device_id = "109829";

        $client = new \GuzzleHttp\Client();
        $response = $client->post("https://smsgateway.me/api/v4/message/send",
            [
                'headers' => [
                    'Authorization' => $Authorization,
                ],
                'json' => [
                    [
                        'phone_number' => $phone_number,
                        'message' => $message,
                        'device_id' => $device_id
                    ]
                ],
            ]
        );
        (new Linenotify)->line($response->getStatusCode());
        if($response->getStatusCode() != 200)
        {
            (new Linenotify)->line('แจ้งเตือน : ระบบ SMS.ME เกิดปัญหา ไม่สามารถทำงานได้่');
        }
        return $response->getStatusCode();
    }
}
