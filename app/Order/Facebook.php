<?php

namespace App\Order;

// use App\URL;
use App\URL;
use App\MSms;
use App\Helper;
use App\Linenotify;
use App\Order\Line;
use App\Order\Setting;
use App\Order\ShotlinkV2;
// use Google\Service\Compute\Help;
use Illuminate\Support\Str;
use App\Order\RegisterMemberTemp;
use App\Order\KsherChannelPayment;
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
            // Facebook::update_profile($profile, $message);
            $profile->update(["updated_at" => now()]);
        }
        return $profile;
    }

    public static function update_profile($profile, $message = null)
    {
        if ($profile->updated_at < now()->subDays(7)) {
            // $get_profile = Facebook::get_profile($profile->psid);
            $profile->update([
                "first_name" => $message,
                // "last_name" => $get_profile["last_name"],
            ]);
        }
    }

    public static function update_profile_by_message($profile, $message = null)
    {
        // if (is_null($profile->customer_id)) {
        $profile->update([
            "first_name" => $message,
        ]);
        // }
    }

    public static function welcome_date($profile)
    {
        $profile->update(["welcome_date" => now()->format("Y-m-d")]);
        $store_day_off = StoreDayOff::where("start_date", "<=", now()->format("Y-m-d"))
            ->where("end_date", ">=", now()->format("Y-m-d"))
            ->where("end_time", ">", now()->format("H:i:s"))
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
เมนูแบบทั่วไป https://punpang.net/menu
เมนูแบบล่าสุด https://punpang.net/menu/orders
หรือ https://bit.ly/3GdYyTt

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
            CURLOPT_URL => 'https://graph.facebook.com/v14.0/me/messages?access_token=' . self::access_token(),
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

    public static function reply_image_v2($sender, $url)
    {
        $url = self::url() . self::version() . 'me/messages?access_token=' . self::access_token();

        $data = [
            "messaging_type" => "RESPONSE",
            "recipient" => [
                "id" => $sender
            ],
            "message" => [
                "attachment" => [
                    "type" => "image",
                    "payload" => [
                        "url" => $url,
                        "is_reusable" => true
                    ]
                ]
            ]
        ];

        // {
        //     "recipient": {
        //         "id": "' . $sender . '"
        //     },
        //     "message": {
        //     "attachment": {
        //         "type" : "image",
        //         "payload" : {
        //             "url" : "' . $url . '",
        //             "is_reusable" : true
        //         }
        //     }
        // }
        // }

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, ['form_params' => $data]);

        if ($response->getStatusCode() != 200) {
            Linenotify::send("Facebook::reply_message_v2 || ERROR::" . $response->getBody());
        }

        return $response->getBody();
    }

    public static function reply_message_v2($sender, $message)
    {
        $url = self::url() . self::version() . 'me/messages?access_token=' . self::access_token();

        $data = [
            "messaging_type" => "RESPONSE",
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

    public static function send_reply_message($order, $message, $status_send = true)
    {
        if (
            $order->OrderChannel->keyword != "facebook" ||
            empty($order->customer->facebook) ||
            $order->customer->facebook->updated_at->addHours("23") < now() ||
            $status_send == false
        ) {
            return;
        }
        Facebook::reply_message_v2($order->customer->facebook->psid, $message);
    }

    public static function send_reply_image($order, $url, $status_send = true)
    {
        if (
            $order->OrderChannel->keyword != "facebook" ||
            empty($order->customer->facebook) ||
            $order->customer->facebook->updated_at->addHours("23") < now() ||
            $status_send == false
        ) {
            return;
        }
        Facebook::reply_image($order->customer->facebook->psid, $url);
    }

    public static function send_postback($order, $elements, $status_send = true)
    {
        if (
            $order->OrderChannel->keyword != "facebook" ||
            empty($order->customer->facebook) ||
            $order->customer->facebook->updated_at->addHours("23") < now() ||
            $status_send == false
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

        if ($keyword == "genarate_qrcode_promtpay_to_facebook") {
            // Linenotify::send("genarate_qrcode_promtpay_to_facebook");

            self::set_qrcode_payment($postback["order_id"]);
        }

        if ($keyword == "extend_payment_time") {
            // $order = AOrder::find($postback["order_id"]);
            $url = Url::base() . "/manages/order/" . $postback["order_id"] . "/showOrderByID";
            Linenotify::send("รายการสั่งซื้อ #" . $postback["order_id"] . " -> ขอขยายเวลาชำระเงิน -> $url");
            return;
        }

        if ($keyword == "account_number_and_slip_attachment_link") {
            $order = AOrder::find($postback["order_id"]);
            ACustomer::consent_condition($order->customer);
            // if ($order->updated_at < now()->subMinutes(1)->format("Y-m-d H:i:s")) {
            //     return;
            // }

            if (
                $order->payment_deadline < now()->format("Y-m-d H:i:s")

                // && $order->sumBalance() == 0
            ) {
                Facebook::send_postback(
                    $order,
                    [
                        [
                            "title" => "โปรดแจ้งทางร้าน เพื่อขยายเวลาชำระเงิน",
                            "buttons" => [
                                [
                                    "title" => "ขอขยายเวลาชำระเงิน",
                                    "payload" => json_encode(
                                        [
                                            "keyword" => "extend_payment_time",
                                            "order_id" => $order->id
                                        ]
                                    ),
                                    "type" => "postback"
                                ]
                            ]
                        ]
                    ]
                );
                return;
            }

            // $url = Url::base() . "/upload_slip/$order->auth_order";

            // if ($order->status_full_payment || $order->sumDeposited() > 0) {
            //     $msg = "โปรดชำระด้วยจำนวนเงิน " . number_format($order->sumBalance(), 2) . " บาท";
            // } else {
            //     $msg = "โปรดเลือกชำระด้วยจำนวนเงินระหว่าง " . number_format($order->sumTASC(), 2) . " บาท หรือ " . number_format($order->sumTASC() / 2, 2) . " บาท";
            // }

            $msg = "โปรดรอสักครู่! ระบบกำลังประมวลผล";
            Facebook::send_reply_message($order, $msg);
            Facebook::text_account_number_and_slip_attachment_link($order);
            return;

            $msg = "โปรดชำระด้วยจำนวนเงิน
" . number_format($order->sumBalance(), 2) . " บาท";

            $bank = "ช่องทางการโอนชำระเงิน
พร้อมเพย์ (แนะนำ)
0918853402
ฐิติภัทร ศรีสุข

ธนาคารไทยพาณิชย์
4191081549
ฐิติภัทร ศรีสุข

True Wallet (ทรูวอลเลท)
*โปรดแจ้ง หากสะดวกชำระช่องทางนี้*";

            $msg = $msg . "
--------------------
โปรดแจ้งชำระเงินก่อน
$order->payment_deadline_th น.
--------------------
$bank
--------------------
**หลังจากลูกค้าชำระเงินแล้ว ร้านสงวนสิทธิ์ว่าลูกค้าตรวจสอบรายการสั่งซื้อแล้ว**
***โปรดแจ้งชำระเงินภายในวัน-เวลาที่ร้านกำหนด***
****ร้านสงวนสิทธิ์ในการจัดลำดับคิวใหม่ หากแจ้งชำระเงินไม่ทันตามวัน-เวลาที่ร้านกำหนด****";



            // Facebook::send_reply_image($order, "https://lh3.googleusercontent.com/d/1mEoi5PyWNPcQnvZ_FyNWiGZUT6PLYgB7");

            $generate_phone_promptpay = Helper::generate_phone_promptpay($order->sumBalance());
            $generate_qrcode_text = Helper::generate_qrcode_text($generate_phone_promptpay);
            Facebook::send_reply_image($order, URL::base_to_link($generate_qrcode_text));
            unlink($generate_qrcode_text);

            Facebook::send_reply_message($order, $msg);

            // Facebook::send_postback(
            //     $order,
            //     [
            //         [
            //             "title" => "แนบสลิปหลังชำระเงิน โดยกดที่ปุ่มด้านล่าง",
            //             "subtitle" => "หรือส่งสลิปเข้ามาในแชตก่อนวัน-เวลากำหนดชำระเงิน",
            //             "buttons" => [
            //                 [
            //                     "title" => "กดเพื่อแจ้งชำระเงิน",
            //                     "url" => $url,
            //                     "type" => "web_url"
            //                 ],
            //             ]
            //         ]
            //     ]
            // );
        }
    }

    public static function text_account_number_and_slip_attachment_link($order)
    {
        $msg = "โปรดชำระด้วยจำนวนเงิน
" . number_format($order->sumBalance(), 2) . " บาท";

        $bank = "ช่องทางการโอนชำระเงิน
พร้อมเพย์ (แนะนำ)
0918853402
ฐิติภัทร ศรีสุข

ธนาคารไทยพาณิชย์
4191081549
ฐิติภัทร ศรีสุข

True Wallet (ทรูวอลเลท)
*โปรดแจ้ง หากสะดวกชำระช่องทางนี้*";

        $msg = $msg . "
--------------------
โปรดแจ้งชำระเงินก่อน
$order->payment_deadline_th น.
--------------------
$bank
--------------------
**หลังจากลูกค้าชำระเงินแล้ว ร้านสงวนสิทธิ์ว่าลูกค้าตรวจสอบรายการสั่งซื้อแล้ว**
***โปรดแจ้งชำระเงินภายในวัน-เวลาที่ร้านกำหนด***
****ร้านสงวนสิทธิ์ในการจัดลำดับคิวใหม่ หากแจ้งชำระเงินไม่ทันตามวัน-เวลาที่ร้านกำหนด****";



        // Facebook::send_reply_image($order, "https://lh3.googleusercontent.com/d/1mEoi5PyWNPcQnvZ_FyNWiGZUT6PLYgB7");

        $generate_phone_promptpay = Helper::generate_phone_promptpay($order->sumBalance());
        $generate_qrcode_text = Helper::generate_qrcode_text($generate_phone_promptpay);
        Facebook::send_reply_image($order, URL::base_to_link($generate_qrcode_text));
        unlink($generate_qrcode_text);

        Facebook::send_reply_message($order, $msg);
    }

    public static function set_qrcode_payment($order_id)
    {
        // Linenotify::send("set_qrcode_payment");
        $order = AOrder::find($order_id);

        $ksher = KsherChannelPayment::where("payment_code", "promptpayQR")
            ->where("status_use", 1)
            ->where("maximum", ">=", $order->sumTASC())
            ->WhereDoesntHave("ksherDayOff", function ($query) {
                return $query->where("day_off", \Carbon\Carbon::now()->format('Y-m-d'));
            })->first();

        if (
            !$ksher ||
            // $order->status >= 3 &&
            $order->payment_deadline <= now()->format('Y-m-d H:i:s')
            // && $order->sumBalance() == 0
            || $order->sumMoneyCustomer() > 0

        ) {
            // !$has_fee
            Facebook::send_postback(
                $order,
                [
                    [
                        "title" => "โปรดชำระเงินโดยกดปุ่ม ชำระเงิน",
                        "subtitle" => "ไม่สามารถสร้าง QR CODE พร้่อมเพย์ได้",
                        "buttons" => [
                            [
                                "title" => "ชำระเงิน",
                                "url" => $order->link_for_customer,
                                "type" => "web_url"
                            ],
                        ]
                    ]
                ]
            );
            // Facebook::send_reply_message($order, $msg);
            return;
        }

        $msg = "โปรดรอสักครู่ ระบบกำลังสร้าง QR CODE สำหรับสแกนจ่าย";

        Facebook::send_reply_message($order, $msg);

        $base64 = KsherPay::create_qrcode_promptpay_by_facebook($order, $ksher->fee_value);

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $unique = Str::uuid();
        file_put_contents("images/qr-code/$unique.png", $data);
        $url = URL::base() . "/images/qr-code/$unique.png";

        Facebook::send_reply_image($order, $url);
        $msg_fee = $ksher->fee_value > 0 ? "และมีค่าธรรมเนียม $ksher->fee_value บาท" : "";
        $msg = "ชำระเงินด้วยยอด " . number_format($order->sumBalance(), 2) . " บาท $msg_fee
------------------------------
QR CODE นี้ จะหมดอายุ
" . now()->addMinutes(10)->format("d/m/y H:i:s") . " น.
------------------------------
**ใช้ QR CODE พร้อมเพย์นี้ สแกนจ่ายเพื่อชำระเงินได้เลยค่ะ สะดวก รวดเร็ว ไม่ต้องส่งสลิป**
***หลังจากลูกค้าชำระเงินแล้ว ทางร้านสงวนสิทธิ์ว่าลูกค้าได้ทำการตรวจสอบรายการสั่งซื้อแล้ว และรายการสั่งซื้อนั้นถูกต้อง***";
        Facebook::send_reply_message($order, $msg);

        unlink("images/qr-code/$unique.png");
        return response()->json([], 200);
    }

    public static function payment_by_facebook_image_first()
    {
    }

    public static function payment_by_facebook_image($attachments, $profile)
    {

        // นำข้อมูลมาวนลูป
        // $attachment["payload"]["url"]
        foreach ($attachments as $attachment) {

            // อ่านคิวอาร์โดยลิงก์ url
            $result = Helper::qrCodeReaderUrl_v2($attachment["payload"]["url"]);
            // if ($result == null) {
            //     $image->delete();
            // ถ้ามีข้อมูลคิวอาร์
            if ($result["has_qrcode"]) {

                // แยกเอาเฉพาะ ref บนสลิป
                // $dataQr = Helper::substr_slip_ref($result["text"]);
                $dataQr = $result["text"];

                // ค้นหาว่ามี ref นี้หรือยัง
                $is_have = NoticeOfPaymentFromCustomer::where("ref", $dataQr)->first();
                // if (isset($is_have)) {
                //     $image->delete();
                // }

                // ถ้าไม่มี ref ซ่้ำ
                if (empty($is_have)) {

                    // ค้นหารายการสั่งซื้อที่มีเงื่อนไข
                    // สถานะน้อยกว่า 9(รับสินค้า)
                    // ยังไม่เลยกำหนดชำระเงิน
                    // วันที่รับมากกว่าหรือเท่ากับปัจจุบัน
                    // ช่องทางการสั่งซื้อคือ facebook
                    // เรียงลำดับที่อัพเดทล่าสุด
                    $orders = $profile->customer->orders
                        ->where("status", "<", "9")
                        ->where("payment_deadline", ">=", now()->format("Y-m-d H:i:s"))
                        ->where("date_get", ">=", now()->format("Y-m-d"))
                        ->where("channel", "3")
                        ->sortByDesc("updated_at");

                    // มีข้อมูลรายการสั่งซื้อเท่ากับ 1
                    if ($orders->count() == 1) {

                        // เอารายการสั่งซื้อแรก เปลี่ยนตัวแปร
                        $order = $orders->first();

                        // ถ้ายอดคงเหลือมากกว่า 0
                        if ($order->sumBalance() > 0) {
                            // สร้างการแจ้งเตือนชำระเงินจากลูกค้า
                            $notice = NoticeOfPaymentFromCustomer::create([
                                "order_id" => $order->id,
                                "src_name" => $attachment["payload"]["url"],
                                "status" => "create",
                                "amount" => $order->sumBalance(),
                                "ref" => $dataQr
                            ]);
                            Linenotify::send("รับชำระเงินจากลูกค้า -> #$order->id -> Facebook");

                            NoticeOfPaymentFromCustomer::setSuccessFromVerifySlip($result["text"], $notice);
                            // แจ้งเตือนไลน์
                        }
                        // AlertMessages::bothNoticeOfPaymentByCustomer($order->id, 0);
                        // AlertMessages::socialNoticeOfPaymentByCustomer($order, 0);
                    }
                    // else if ($orders->count() == 0) {
                    //     $facebook_link = str_starts_with($orders->customer->social_is, "https") ? " -> $orders->customer->social_is" : "";
                    //     Linenotify::send("$facebook_link");
                    // }

                    // มีข้อมูลรายการสั่งซื้อไม่เท่ากับ 1
                    else {
                        $message = $orders->count() == 0 ? "ลูกค้าส่งสลิปเข้ามาในแชต แต่ไม่มีรายการสั่งซื้อรองรับ" : "ลูกค้าส่งสลิปเข้ามาในแชต แต่มีมากกว่า 1 คำสั่งซื้อขณะนี้";
                        Linenotify::send($message);
                    }
                }
            }
        }
    }

    public static function register_wongnai_pos_bill($bill, $profile)
    {
        if (strlen($bill) == 5) {
            $pattern = '/[A-Z0-9][A-Z0-9][A-Z0-9][A-Z0-9][A-Z0-9]/';
            $uppercase = strtoupper($bill);
            if (preg_match($pattern, $uppercase)) {
                // 3 สามารถลงทะเบียนได้ 10 ใบเสร็จ / 1 ชั่วโมง โปรดลองอีกครั้งภายหลัง
                $count_in_hours = RegisterWongnaiPosBill::where("facebook_id", $profile->id)
                    ->where("created_at", ">=", now()->subDays(1)->format("Y-m-d H:i:s"))
                    ->get();
                if ($count_in_hours->count() > 5) {
                    Facebook::reply_message_v2($profile->psid, "ท่านสามารถลงทะเบียนได้
5 ใบเสร็จ / วัน
โปรดลองอีกครั้งภายหลัง");
                    return;
                }

                $find = RegisterWongnaiPosBill::where("bill_id", $uppercase)->first();
                if (is_null($find)) {
                    RegisterWongnaiPosBill::create([
                        "bill_id" => $uppercase,
                        "facebook_id" => $profile->id
                    ]);
                    Facebook::reply_message_v2($profile->psid, "ลงทะเบียนใบเสร็จเรียบร้อย");
                    // 1 ลงทะเบียนใบเสร็จเรียบร้อย
                } else {
                    Facebook::reply_message_v2($profile->psid, "ใบเสร็จนี้ ! เคยลงทะเบียนแล้ว");

                    // 2 ใบเสร็จนี้เคยลงทะเบียนแล้ว
                }

                if (empty($profile->customer)) {
                    //                     Facebook::reply_message_v2($profile->psid, "ท่านยังไม่ได้เป็นสมาชิก

                    // สมัครสมาชิกง่าย ๆ เพียงพิมพ์

                    // สมัครสมาชิก
                    // ชื่อ
                    // เบอร์โทร

                    // 📌 ตัวอย่าง
                    // สมัครสมาชิก
                    // ไก่
                    // 0123456789

                    // ❗️ โปรดพิมพ์ข้อมูลตามตัวอย่างเท่านั้น");

                    $url = Helper::temporarySignedRouteUrl(
                        "register_member_by_facebook",
                        now()->addMinutes(5),
                        ["psid" => $profile->psid]
                    );

                    $link = Helper::get_params_url($url);

                    $link = ShotlinkV2::store("/register_member?" . $link["query"], 1);

                    Facebook::postback(
                        $profile->psid,
                        [
                            [
                                "title" => "ท่านยังไม่ได้เป็นสมาชิก",
                                "buttons" => [
                                    [
                                        "title" => "สมัครสมาชิก",
                                        "url" => $link,
                                        "type" => "web_url"
                                    ]
                                ]
                            ]
                        ]

                    );
                }
            }
            return "false - no pattern";
        }

        return "false - no lenght 5";
    }
}
