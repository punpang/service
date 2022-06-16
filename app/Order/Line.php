<?php

namespace App\Order;

use App\URL;
use App\MSms;
use App\Linenotify;
use App\Order\Setting;
use App\Order\ShotlinkV2;
use App\Order\RegisterMemberTemp;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $table = "lines";
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at', "userId"];
    public $access_token;

    public function customer()
    {
        return $this->belongsTo(ACustomer::class, "customer_id", "id");
    }

    public static function access_token()
    {
        $setting = Setting::first();
        if ($setting->line_expiration_date <= now() || $setting->line_access_token == null) {
            $get_access_token = self::get_access_token($setting->line_client_id, $setting->line_client_secret);
            $setting->line_access_token = $get_access_token["access_token"];
            $setting->line_expiration_date = now()->addDays(29);
            $setting->save();
        }
        return $setting->line_access_token;
    }

    public static function url()
    {
        return "https://api.line.me/";
    }

    public static function version()
    {
        return 'v2/';
    }

    public static function sumCustomerScore($profile, $replyToken)
    {
        if ($profile->customer == null) {
            Line::reply_message_v2($replyToken, "คุณยังไม่ได้เป็นสมาชิก");
        } else {
            $ms = "คุณมีคะแนนสะสม " . $profile->customer->sumDiffScore() . " คะแนน";
            Line::reply_message_v2($replyToken, $ms);
        }
        return;
    }

    public static function create_profile($userId)
    {
        $profile = Line::where("userId", $userId)->first();
        if (!$profile) {
            $get_profile = self::get_profile($userId);
            Line::create([
                "displayName" => $get_profile["displayName"],
                "userId" => $get_profile["userId"],
            ]);
        } else {
            $profile->update(["updated_at" => now()]);
        }

        return $profile;
    }

    public static function get_profile($userId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.line.me/v2/bot/profile/' . $userId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . self::access_token()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        return json_decode($response, true);
    }

    public static function reply_message($replyToken, $text, $encode = false)
    {
        if ($encode) {
            $text = json_encode($text, true);
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.line.me/v2/bot/message/reply',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "replyToken": "' . $replyToken . '",
                "messages": [
                    {
                        "type": "text",
                        "text": ' . $text . '
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . self::access_token()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public static function reply_message_v2($replyToken, $text)
    {
        $url = self::url() . self::version() . 'bot/message/reply';

        $data = [
            "replyToken" => $replyToken,
            "messages" => [
                [
                    "type" => "text",
                    "text" => $text
                ]
            ]
        ];

        $headers = [
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . self::access_token()
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['json' => $data, "headers" => $headers]);

        if ($response->getStatusCode() != 200) {
            Linenotify::send("Line::reply_message_v2 || ERROR :: " . $response->getBody());
        }

        return $response->getBody();
    }

    public static function reply_messages($replyToken, $text)
    {
        Linenotify::send('fcghfcvh');
        Linenotify::send(count($text));
        if (count($text) > 5) {
            $count = 5;
        } else {
            $count = count($text);
        }

        for ($i = 0; $i < $count; $i++) {
            $messages[] = [
                "type" => "text",
                "text" => $text[$i]
            ];
        }

        $url = self::url() . self::version() . 'bot/message/reply';

        $data = [
            "replyToken" => $replyToken,
            "messages" => $messages
        ];

        $headers = [
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . self::access_token()
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['json' => $data, "headers" => $headers]);

        if ($response->getStatusCode() != 200) {
            Linenotify::send("Line::reply_message_v2 || ERROR :: " . $response->getBody());
        }

        return $response->getBody();
    }

    public static function reply_flex_message($replyToken, $contents, $encode = false)
    {

        if ($encode) {
            $contents = json_encode($contents, true);
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.line.me/v2/bot/message/reply',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "replyToken": "' . $replyToken . '",
                "messages":[
                    ' . $contents . '
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . self::access_token()
            ),
        ));


        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public static function reply_flex_message_v2($replyToken, $contents)
    {
        $url = self::url() . self::version() . 'bot/message/reply';

        $data = [
            "replyToken" => $replyToken,
            "messages" => [
                $contents
            ]
        ];

        $headers = [
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . self::access_token()
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['json' => $data, "headers" => $headers]);

        if ($response->getStatusCode() != 200) {
            Linenotify::send("Line::reply_flex_message_v2 || ERROR");
        }

        return $response->getBody();
    }

    public static function push_message($userId, $text, $encode = false)
    {
        if ($encode) {
            $text = json_encode($text);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.line.me/v2/bot/message/push',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "to": "' . $userId . '",
                "messages":[
                    {
                        "type":"text",
                        "text":' . $text . '
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . self::access_token()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public static function push_message_v2($userId, $text)
    {
        $url = self::url() . self::version() . 'bot/message/push';

        $data = [
            "to" => $userId,
            "messages" => [
                [
                    "type" => "text",
                    "text" => $text
                ]
            ]
        ];

        $headers = [
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . self::access_token()
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['json' => $data, "headers" => $headers]);

        if ($response->getStatusCode() != 200) {
            Linenotify::send("Line::push_message_v2 || ERROR :: " . $response->getBody());
        }

        return $response->getBody();
    }

    public static function push_flex_message($userId, $messages, $encode = false)
    {
        if ($encode) {
            $messages = json_encode($messages, true);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.line.me/v2/bot/message/push',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "to": "' . $userId . '",
                "messages":[
                    ' . $messages . '
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . self::access_token()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function push_flex_message_v2($userId, $contents)
    {
        $url = self::url() . self::version() . 'bot/message/push';

        $data = [
            "to" => $userId,
            "messages" => [
                $contents
            ]
        ];

        $headers = [
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . self::access_token()
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['json' => $data, "headers" => $headers]);

        if ($response->getStatusCode() != 200) {
            Linenotify::send("Line::push_flex_message_v2 || ERROR :: " . $response->getBody());
        }

        return $response->getBody();
    }

    public static function get_access_token($client_id, $client_secret)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.line.me/v2/oauth/accessToken',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=' . $client_id . '&client_secret=' . $client_secret,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        return json_decode($response, true);
    }

    public static function update_access_token()
    {
        $LineAccessToken = LineAccessToken::first();
        if ($LineAccessToken->expiration_date <= now() || $LineAccessToken->access_token == null) {
            $get_access_token = self::get_access_token($LineAccessToken->client_id, $LineAccessToken->client_secret);
            $LineAccessToken->access_token = $get_access_token["access_token"];
            $LineAccessToken->expiration_date = now()->addDays(29);
            $LineAccessToken->save();
        }
    }

    public static function send($order, $message)
    {
        if (
            $order->OrderChannel->keyword != "line" ||
            $order->customer->line->updated_at->addHours("23") < now()
        ) {
            return;
        }

        line::push_message($order->customer->line->userId, $message, true);
    }

    public static function send_v2($order, $message)
    {
        if (
            $order->OrderChannel->keyword != "line" ||
            $order->customer->line->updated_at->addHours("23") < now()
        ) {
            return;
        }

        line::push_message_v2($order->customer->line->userId, $message);
    }

    public static function flex_alert_payment($order)
    {
        if (
            $order->OrderChannel->keyword != "line" ||
            $order->customer->line->updated_at->addHours("23") < now()
        ) {
            return;
        }

        $customer = $order->customer;
        $sumTASC = number_format($order->sumTASC(), 2);

        $postback = [
            "keyword" => "not_comfirm_payment",
            "order_id" => $order->id,
            "link_for_customer" => $order->link_for_customer
        ];
        $message =
            [
                "type" => "flex",
                "altText" => "รายละเอียดและชำระเงิน",
                "contents" => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "แจ้งชำระเงิน",
                                "weight" => "bold",
                                "size" => "xl"
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => "lg",
                                "spacing" => "sm",
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => "sm",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "color" => "#aaaaaa",
                                                "size" => "sm",
                                                "flex" => 4,
                                                "text" => "หมายเลขคำสั่งซื้อ"
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "#$order->id",
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => "sm",
                                                "flex" => 5,
                                                "align" => "end"
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "separator",
                                        "margin" => "md"
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => "sm",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "ชื่อลูกค้า",
                                                "color" => "#aaaaaa",
                                                "size" => "sm",
                                                "flex" => 4
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$customer->name",
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => "sm",
                                                "flex" => 5,
                                                "align" => "end"
                                            ]
                                        ],
                                        "margin" => "md"
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "เบอร์โทรศัพท์",
                                                "flex" => 4,
                                                "color" => "#aaaaaa",
                                                "size" => "sm"
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$customer->tel",
                                                "color" => "#666666",
                                                "size" => "sm",
                                                "flex" => 5,
                                                "align" => "end"
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "separator",
                                        "margin" => "md"
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => "sm",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "color" => "#aaaaaa",
                                                "size" => "sm",
                                                "flex" => 4,
                                                "text" => "วันที่นัดรับ"
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$order->date_get_th",
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => "sm",
                                                "flex" => 5,
                                                "align" => "end"
                                            ]
                                        ],
                                        "margin" => "md"
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => "sm",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "เวลาที่นัดรับ",
                                                "color" => "#aaaaaa",
                                                "size" => "sm",
                                                "flex" => 4
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$order->time_get น.",
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => "sm",
                                                "flex" => 5,
                                                "align" => "end"
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "separator",
                                        "margin" => "md"
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => "sm",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "สรุปยอดทั้งหมด",
                                                "color" => "#aaaaaa",
                                                "size" => "sm",
                                                "flex" => 4
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$sumTASC บาท",
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => "sm",
                                                "flex" => 5,
                                                "align" => "end"
                                            ]
                                        ],
                                        "margin" => "md"
                                    ],
                                    [
                                        "type" => "separator",
                                        "margin" => "md"
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => "sm",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "โปรดชำระก่อน",
                                                "color" => "#aaaaaa",
                                                "size" => "sm",
                                                "flex" => 4
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$order->payment_deadline_th น.",
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => "sm",
                                                "flex" => 6,
                                                "align" => "end"
                                            ]
                                        ],
                                        "margin" => "md"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "footer" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "spacing" => "sm",
                        "contents" => [
                            [
                                "type" => "button",
                                "style" => "primary",
                                "height" => "sm",
                                "action" => [
                                    "type" => "uri",
                                    "label" => "รายละเอียดและชำระเงิน",
                                    "uri" => "$order->link_for_customer"
                                ]
                            ],
                            [
                                "type" => "button",
                                "height" => "sm",
                                "action" => [
                                    "type" => "postback",
                                    "label" => "ไม่สะดวกชำระเงิน",
                                    "data" => json_encode($postback)
                                ]
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "contents" => [],
                                "margin" => "sm"
                            ]
                        ],
                        "flex" => 0
                    ]
                ]
            ];
        self::push_flex_message_v2($order->customer->line->userId, $message);
    }

    public static function flex_customer_noPayment($order, $waiting_period)
    {
        if (
            $order->OrderChannel->keyword != "line" ||
            $order->customer->line->updated_at->addHours("23") < now()
        ) {
            return;
        }

        $message =
            [
                "type" => "flex",
                "altText" => "ไม่สะดวกชำระเงิน",
                "contents" => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "ไม่สะดวกชำระเงิน",
                                "weight" => "bold",
                                "size" => "xl"
                            ],
                            [
                                "type" => "text",
                                "text" => "ทางร้านขอนัดลูกค้าเข้าร้าน $order->date_get_th $order->time_get น. เพื่อรอจัดเตรียมสินค้า $waiting_period",
                                "margin" => "sm",
                                "wrap" => true
                            ],
                            [
                                "type" => "separator",
                                "margin" => "md"
                            ],
                            [
                                "type" => "text",
                                "text" => "*หากลูกค้าเข้าร้านก่อนหรือหลังเวลาที่นัด อาจใช้เวลาการเตรียมมากว่าปกติ",
                                "wrap" => true,
                                "size" => "xs",
                                "margin" => "md",
                                "color" => "#aaaaaa"
                            ]
                        ]
                    ],
                    "footer" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "spacing" => "xs",
                        "contents" => [
                            [
                                "type" => "button",
                                "style" => "link",
                                "height" => "sm",
                                "action" => [
                                    "type" => "uri",
                                    "label" => "รายละเอียดและชำระเงิน",
                                    "uri" => "$order->link_for_customer"
                                ]
                            ]
                        ],
                        "flex" => 0
                    ]
                ]
            ];
        self::push_flex_message_v2($order->customer->line->userId, $message);
    }

    public static function flex_receipt($order)
    {
        if (
            $order->OrderChannel->keyword != "line" ||
            $order->customer->line->updated_at->addHours("23") < now()
        ) {
            return;
        }

        $sumTASC = number_format($order->sumTASC(), 2);
        $sumDeposited = number_format($order->sumDeposited(), 2);
        $sumBalance = number_format($order->sumBalance(), 2);

        $message =
            [
                "type" => "flex",
                "altText" => "ขอบคุณที่ชำระเงิน",
                "contents" => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "ใบเสร็จ",
                                "weight" => "bold",
                                "color" => "#1DB446",
                                "size" => "sm"
                            ],
                            [
                                "type" => "text",
                                "text" => "ขอบคุณที่ชำระเงิน",
                                "weight" => "bold",
                                "size" => "xxl",
                                "margin" => "md"
                            ],
                            [
                                "type" => "text",
                                "text" => "หมายเลขคำสั่งซื้อ #$order->id",
                                "size" => "xs",
                                "color" => "#aaaaaa",
                                "wrap" => true,
                                "margin" => "sm"
                            ],
                            [
                                "type" => "separator",
                                "margin" => "lg"
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => "none",
                                "spacing" => "sm",
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "horizontal",
                                        "margin" => "md",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "รวมทั้งหมด",
                                                "size" => "sm",
                                                "color" => "#555555"
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$sumTASC บาท",
                                                "size" => "sm",
                                                "color" => "#111111",
                                                "align" => "end"
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "horizontal",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "ชำระแล้ว",
                                                "size" => "sm",
                                                "color" => "#555555"
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$sumDeposited บาท",
                                                "size" => "sm",
                                                "color" => "#111111",
                                                "align" => "end"
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "horizontal",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "คงเหลือ",
                                                "size" => "sm",
                                                "color" => "#555555"
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => "$sumBalance บาท",
                                                "size" => "sm",
                                                "color" => "#111111",
                                                "align" => "end"
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                "type" => "separator",
                                "margin" => "lg"
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "contents" => [
                                    [
                                        "type" => "button",
                                        "action" => [
                                            "type" => "uri",
                                            "label" => "รายละเอียดเพิ่มเติม",
                                            "uri" => "$order->link_for_customer"
                                        ],
                                        "style" => "primary",
                                        "margin" => "lg"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "styles" => [
                        "footer" => [
                            "separator" => true
                        ]
                    ]
                ]
            ];

        self::push_flex_message_v2($order->customer->line->userId, $message);
    }

    public static function register_member($replyToken, $userId, $message)
    {
        $explode = explode("\n", strval($message));
        if (
            count($explode) == 3 &&
            $explode[0] == "สมัครสมาชิก" && // พิมพ์ "สมัครสมาชิก"
            $explode[2][0] == 0 && // เบอร์โทรหลักแรก เป็นเลข 0
            strlen($explode[2]) == 10 && // นับจำนวนตัวอักษรในเบอร์โทร
            is_numeric($explode[2]) // ตรวจสอบเบอร์โทรว่าเป็นตัวเลข
        ) {
            // สร้างข้อมูล
            $temp = RegisterMemberTemp::create([
                "name" => $explode[1],
                "phone" => $explode[2],
                "psid_userId" => $userId,
                "token" => bin2hex(openssl_random_pseudo_bytes(32)),
                "channel" => "line",
                "expiration_date" => now()->addMinutes("15")->format("Y-m-d H:i:s")
            ]);
            // sms พร้อมลิงก์
            // $link = URL::base() . "/verify_identity/register_member/" . $temp->token;
            $link = ShotlinkV2::store("/verify_identity/register_member/" . $temp->token, 1);
            MSms::Sms($temp->phone, "คลิกลิงก์ [ " . $link . " ] เพื่อยืนยันการสมัครสมาชิก โปรดทำรายการภายใน 15 นาที");
            Line::reply_message_v2($replyToken, "ระบบได้ส่งลิงก์สำหรับยืนยันตัวตนไปยัง SMS ตามหมายเลขที่ท่านแจ้งไว้ โปรดยืนยันภายใน 15 นาที");
        }
    }

    public static function key_word_postback($replyToken, $postback)
    {
        $keyword = $postback["keyword"];

        if ($keyword == "not_comfirm_payment") {
            // order_id
            // link_for_customer
            // $confirm_no_payment = [
            //     "keyword" => "confirm_no_payment",
            //     "order_id" => $postback["order_id"]
            // ];
            $message =
                [
                    "type" => "flex",
                    "altText" => "ลูกค้าไม่สะดวกชำระเงิน",
                    "contents" => [
                        "type" => "bubble",
                        "body" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => [
                                [
                                    "type" => "text",
                                    "text" => "ลูกค้าไม่สะดวกชำระเงิน",
                                    "weight" => "bold",
                                    "size" => "xl"
                                ],
                                [
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => [
                                        [
                                            "type" => "text",
                                            "text" => "หากไม่สะดวกชำระมัดจำ ต้องรบกวนรอตกแต่งสินค้าหน้าร้าน 15-30 นาที",
                                            "margin" => "md",
                                            "wrap" => true
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "footer" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "spacing" => "sm",
                            "contents" => [
                                [
                                    "type" => "button",
                                    "style" => "link",
                                    "height" => "sm",
                                    "action" => [
                                        "type" => "message",
                                        "label" => "ใช่, สะดวกรอ",
                                        "text" => "สะดวกรอตกแต่งหน้าร้าน"
                                    ]
                                ],
                                [
                                    "type" => "button",
                                    "style" => "link",
                                    "height" => "sm",
                                    "action" => [
                                        "type" => "uri",
                                        "label" => "ชำระเงิน",
                                        "uri" => $postback["link_for_customer"]
                                    ]
                                ],
                                [
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => [],
                                    "margin" => "sm"
                                ]
                            ],
                            "flex" => 0
                        ]
                    ]
                ];

            Line::reply_flex_message_v2($replyToken, $message);
        }
    }
}
