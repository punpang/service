<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    public static function send($number,$text)
    {
        $client = new \GuzzleHttp\Client();
        //dd($client);
        $response = $client->post("https://smsgateway.me/api/v4/message/send",
            [
                'headers' => [
                    'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0NzM3NzMxOSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjUyOTgyLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.rQU3q0NZ0beTn9W0h1IFkU4Aqra__5cgASM7rYBOBvY',
                ],
                'json' => [
                    [
                        'phone_number' => $number,
                        'message' => $text,
                        'device_id' => '109829'
                    ]
                ],
            ]
        );
        return $response->getStatusCode();
    }
}
