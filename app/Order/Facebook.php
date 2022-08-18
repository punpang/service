<?php

namespace App\Order;

// use App\URL;
use App\MSms;
use App\Linenotify;
use App\Order\Setting;
use App\Order\ShotlinkV2;
use App\Order\RegisterMemberTemp;
use Illuminate\Database\Eloquent\Model;

class Facebook extends Model
{
    protected $table = "facebooks";
    protected $guarded = [];
    protected $appends = ["full_name"];
    protected $hidden = ['created_at', 'updated_at', "psid"];
    public $access_token;

    public static function url()
    {
        return "https://graph.facebook.com/";
    }

    public static function version()
    {
        return 'v14.0/';
    }

    public static function pageToken()
    {
        return [
            'app' => env('FACEBOOK_PAGE_APP_ID'),
            'access_token' => env('FACEBOOK_PAGE_ACCESS_TOKEN'),
            'page' => env('FACEBOOK_PAGE_ID'),
            'appsecret_proof' => env('FACEBOOK_PAGE_APPSECRET_PROOF')
        ];
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public static function access_token()
    {
        // $access_token = self::pageToken();
        // return $access_token["access_token"];
        $setting = Setting::first();
        return $setting->facebook_access_token;

        return 'EAAEdfwOocCQBAB4Dv4W6Bcz4ePZBF2U6WOA6p26gdsKDNO7OKv398GjSn3FYhw2CcgNZCJsmWn1s4rABkZCLwj0hgWfZBQvB1AEV7dGODANMzKfJglQA1v5VUqHTrn4BqMzbnx4DcerZAnCoL6Yc7D8gNzTX5zQyKZC179G3RsEKBlhGqosRg7a8zXxFqGuRNrrqcaZBreMKwZDZD';
    }

    public static function create_profile($psid)
    {
        $profile = Facebook::where("psid", $psid)->first();
        if (!$profile) {
            // $get_profile = Facebook::get_profile($psid);
            // $profile = Facebook::create([
            //     "first_name" => $get_profile["first_name"],
            //     "last_name" => $get_profile["last_name"],
            //     "psid" => $get_profile["id"],

            // ]);
            $profile = Facebook::create([
                "first_name" => $psid,
                "last_name" => $psid,
                "psid" => $psid,

            ]);
        } else {
            $profile->update(["updated_at" => now()]);
        }
        return $profile;
    }

    public static function welcome_date($profile)
    {
        $profile->update(["welcome_date" => now()->format("Y-m-d")]);
        $store_day_off = StoreDayOff::where("start_date", "<=", now()->format("Y-m-d"))
            ->where("end_date", ">=", now()->format("Y-m-d"))
            ->orderBy("start_date", "ASC")
            ->orderBy("end_date", "ASC")
            ->first();
        if ($store_day_off == null) {
            $setting = Setting::first();
            // Facebook::reply_message_v2(
            //     $profile->psid,
            //     FacebookReply::replace_value(28, [$setting->open_store, $setting->close_store])
            // );
            Facebook::reply_message_v2($profile->psid, "สวัสดีค่ะ รบกวนรอสักครู่ค่ะ
*ลูกค้าจำเป็นต้องชำระมัดจำทุกกรณีค่ะ
เมนู https://bit.ly/3r5v2ZM หรือ https://bit.ly/3GdYyTt

ร้านเปิดให้บริการทุกวัน
$setting->open_store - $setting->close_store น. ชั่วคราว
(ปกติ 08:30 - 20:00 น.)
*ไม่สามาถรับสินค้าหลังเวลาร้านปิดได้

- ภาพสินค้าของท่าน อาจถูกนำมาใช้ในการประชาสัมพันธ์ของทางร้าน สามารถแจ้งลบได้ทุกเมื่อ
สถานที่ตั้งร้าน : อ.ปราณบุรี จ.ประจวบคีรีขันธ์");
        } else {
            Facebook::reply_message_v2($profile->psid, StoreDayOff::reply_th($store_day_off));
        }
    }

    public static function sumCustomerScore($profile, $sender)
    {
        if ($profile->customer != null) {
            $ms = "คุณมีคะแนนสะสม " . $profile->customer->sumDiffScore() . " คะแนน";
            Facebook::reply_message_v2($sender, $ms);
        } else {
            Facebook::reply_message_v2($sender, "คุณไม่ได้เป็นสมาชิก สมัครสมาชิกง่าย ๆ เพียงพิมพ์ 'สมัครสมาชิก-ชื่อ-เบอร์โทร' ตัวอย่าง 'สมัครสมาชิก-ไก่-0123456789'");
        }
    }

    public function customer()
    {
        return $this->belongsTo(ACustomer::class, "customer_id", "id");
    }

    public static function get_profile($psid)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/' . $psid . '?fields=first_name,last_name,profile_pic&access_token=' . self::access_token(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public static function reply_image($sender, $url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v7.0/me/messages?access_token=' . self::access_token(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "recipient": {
                    "id": "' . $sender . '"
                },
                "message": {
                    "attachment": {
                        "type" : "image",
                        "payload" : {
                            "url" : "' . $url . '",
                            "is_reusable" : true
                        }
                    }
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public static function reply_message($sender, $message, $encode = false)
    {
        if ($encode == true) {
            $message = json_encode($message, true);
        }

        $curl = curl_init();

        // $mg_encode = json_encode($message,true);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v7.0/me/messages?access_token=' . self::access_token(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "recipient": {
                     "id": "' . $sender . '"
                },
                "message": {
                      "text": ' . $message . '
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public static function reply_message_v2($sender, $message)
    {
        $url = self::url() . self::version() . 'me/messages?access_token=' . self::access_token();

        $data = [
            "recipient" => [
                "id" => $sender
            ],
            "message" => [
                "text" => $message,
            ],
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['form_params' => $data]);

        if ($response->getStatusCode() != 200) {
            Linenotify::send("Facebook::reply_message_v2 || ERROR::" . $response->getBody());
        }

        return $response->getBody();
    }

    public static function send_reply_message($order, $message)
    {
        if (
            $order->OrderChannel->keyword != "facebook" ||
            $order->customer->facebook->updated_at->addHours("23") < now()
        ) {
            return;
        }
        Facebook::reply_message_v2($order->customer->facebook->psid, $message);
    }

    public static function send_postback($order, $elements)
    {
        if (
            $order->OrderChannel->keyword != "facebook" ||
            empty($order->customer->facebook) ||
            $order->customer->facebook->updated_at->addHours("23") < now()
        ) {
            return;
        }
        Facebook::postback($order->customer->facebook->psid, $elements);
    }

    public static function postback($psid, $elements = [], $encode = false)
    {
        if ($encode) {
            $elements = json_encode($elements);
        }
        // Linenotify::send(json_encode($elements));
        // $elements = [ // 10 elements
        //     "title" => "", // จำเป็น
        //     "image_url" => "",
        //     "subtitle" => "",
        //     "buttons" => [ // 3 ปุ่ม
        //         [
        //             "type" => "", // จำเป็น web_url | postback
        //             "title" => "", //
        //
        //             "payload" => "" // postback
        //             "url" => "", // web_url
        //         ]
        //     ]
        // ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v7.0/me/messages?access_token=' . self::access_token(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "recipient": {
                "id": "' . $psid . '"
            },
            "message": {
                "attachment": {
                    "type": "template",
                    "payload": {
                        "template_type": "generic",
                        "elements":
                            ' . json_encode($elements, true) . '

                    }
                }
            }
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function postback_v2($psid, $elements = [])
    {
        // Linenotify::send(json_encode($elements));
        // $elements = [ // 10 elements
        //     "title" => "", // จำเป็น
        //     "image_url" => "",
        //     "subtitle" => "",
        //     "buttons" => [ // 3 ปุ่ม
        //         [
        //             "type" => "", // จำเป็น web_url | postback
        //             "title" => "", //
        //
        //             "payload" => "" // postback
        //             "url" => "", // web_url
        //         ]
        //     ]
        // ];

        $url = self::url() . self::version() . 'me/messages?access_token=' . self::access_token();

        $data = [
            "recipient" => [
                "id" => $psid
            ],
            "message" => [
                "attachment" => [
                    "type" => "template",
                    "payload" => [
                        "template_type" => "generic",
                        "elements" => $elements

                    ]
                ]
            ],
        ];
        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['form_params' => $data]);

        if ($response->getStatusCode() != 200) {
            Linenotify::send("Facebook::postback_v2 || ERROR::" . $response->getBody());
        }

        return $response->getBody();
    }

    public static function register_member($sender, $message)
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
                "psid_userId" => $sender,
                "token" => bin2hex(openssl_random_pseudo_bytes(32)),
                "channel" => "facebook",
                "expiration_date" => now()->addMinutes("15")->format("Y-m-d H:i:s")
            ]);
            $link = ShotlinkV2::store("/verify_identity/register_member/" . $temp->token, 1);
            MSms::Sms($temp->phone, "คลิกลิงก์ [ " . $link . " ] เพื่อยืนยันการสมัครสมาชิก โปรดทำรายการภายใน 15 นาที");
            Facebook::reply_message_v2($sender, "ระบบได้ส่งลิงก์สำหรับยืนยันตัวตนไปยัง SMS ตามหมายเลขที่ท่านแจ้งไว้ โปรดยืนยันภายใน 15 นาที");
            return true;
        }

        return false;
    }

    public static function key_word_postback($sender, $postback)
    {
        $keyword = $postback["keyword"];
        if ($keyword == "not_confirm_payment") {
            // order_id
            // link_for_customer
            Facebook::reply_message_v2($sender, "หากไม่สะดวกชำระมัดจำ ต้องรบกวนรอตกแต่งสินค้าหน้าร้าน 15-30 นาที");
            Facebook::postback_v2(
                $sender,
                [
                    [
                        "title" => "ลูกค้าสะดวกรอใช่ไหมคะ",
                        "buttons" => [
                            [
                                "title" => "ใช่, สะดวกรอ",
                                "payload" => "ใช่, สะดวกรอ",
                                "type" => "postback"
                            ],
                            [
                                "title" => "ชำระเงิน",
                                "url" => $postback["link_for_customer"],
                                "type" => "web_url"
                            ]
                        ]
                    ]
                ]
            );
        }
    }
}
