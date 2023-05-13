<?php

namespace App;

// use Carbon\Carbon;
// use Google\Service\HangoutsChat\Card;

// use App\Order\AllowedCheckSlip;
use Zxing\QrReader;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Helper extends Model
{
    public static function generateToken($length = 30)
    {
        return Str::random(60);

        $timestamp = str_split(\Carbon\Carbon::now()->timestamp);

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $data = '';

        for ($i = 0; $i < $length; $i++) {
            if ($i % 3 == 0 && $i <= 30) {
                $n = ($i / 3) / 1;
                $data .= $timestamp[$n];
            } else {
                $data .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            }
        }

        return $data;
    }

    public static function randomNumber($length = 30)
    {
        $timestamp = str_split(\Carbon\Carbon::now()->timestamp);

        $chars = '0123456789';
        $data = '';

        for ($i = 0; $i < $length; $i++) {
            if ($i % 3 == 0 && $i <= 30) {
                $n = ($i / 3) / 1;
                $data .= $timestamp[$n];
            } else {
                $data .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            }
        }

        return $data;
    }

    public static function backBoolean($boolean)
    {
        if ($boolean == true or $boolean == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function messageUseTime($created_at, $updated_at)
    {
        $useTime = \Carbon\Carbon::parse($updated_at)->diff($created_at);
        if ($useTime->h > 0) {
            $messageUseTime = "ใช้เวลาไป " .  $useTime->h . " ชั่วโมง " . $useTime->i . " นาที " . $useTime->s . " วินาที ";
        } else if ($useTime->i > 0) {
            $messageUseTime = "ใช้เวลาไป " .  $useTime->i . " นาที " . $useTime->s . " วินาที ";
        } else {
            $messageUseTime = "ใช้เวลาไป " . $useTime->s . " วินาที ";
        }

        return $messageUseTime;
    }

    public static function expiredCheck($time, $addMinute = 15)
    {
        // $time = Y-m-d H:i:s

        $timeUp = \Carbon\Carbon::parse($time)->addMinutes($addMinute)->timestamp;
        $timeNow = \Carbon\Carbon::now()->timestamp;

        if ($timeNow > $timeUp) {
            return true;
        }
        return false;
    }



    public static function  CRC16Normal($buffer)
    {
        define('CRC16POLYN', 0x1021);
        $result = 0xFFFF;
        if (($length = strlen($buffer)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $result ^= (ord($buffer[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($result <<= 1) & 0x10000) $result ^= CRC16POLYN;
                    $result &= 0xFFFF;
                }
            }
        }
        return $result;
    }

    public function promptPayQrCode($order)
    {

        // 00020101021153037645802TH29370016A0000006770101110 21318 09900565216 6304E49E
        // 00020101021153037645802TH29370016A0000006770101110 21318 09900565216 540810000.006304 2409

        // 00020101021153037645802TH29370016A0000006770101110 11300 66918853402 63041FE6
        // 00020101021153037645802TH29370016A00000067701011101130066918853402 5406321.006304 8CC5
        $first = "00020101021153037645802TH29370016A00000067701011101130066918853402";
        $amount = number_format($order->sumBalance(), 2, '.', '');
        $countAmount = strlen($amount); //3
        $last = "6304";

        $code = $first . $countAmount . $amount . $last;

        $xFFFF = dechex(Helper::CRC16Normal($code));

        $full = Str::upper($code . $xFFFF);

        return response()->json(
            [
                "full" => $full,
                "xFFFF" => $xFFFF,
            ]
        );
    }

    public static function qrCodeReaderUrl($url)
    {
        // $url_new = str_replace("&", "%26", $url);
        $url_new = urlencode($url);
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://api.qrserver.com/v1/read-qr-code/?fileurl=" . $url_new);
        $result = json_decode($response->getBody(), true);

        if ($result[0]["symbol"][0]["data"] == null) {
            return ["has_qrcode" => false];
        } else {
            return [
                "has_qrcode" => true,
                "text" => $result[0]["symbol"][0]["data"]
            ];
        }
        // return $result;
        // $result[0]["symbol"][0]["data"]
    }

    public static function qrCodeReaderUrl_v2($url)
    {
        // Linenotify::send("qrCodeReaderUrl_v2 $url");
        // $path_to_image = "https://scontent.xx.fbcdn.net/v/t1.15752-9/320485838_707703987368960_3814132955435592475_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=58c789&_nc_ohc=LttICDvKvvcAX_vPtRP&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdQ0V0B9299hGIuyBXGNkcHZmHAsDnzTekBWxsPy0hLbgg&oe=63C73566";
        $qrcode = new QrReader($url);
        $text = $qrcode->text();
        return [
            "has_qrcode" => true,
            "text" => $text
        ];
        if ($text == false) {
            $result = Helper::qrCodeReaderUrl($url);
            return $result;
        } else {
            return [
                "has_qrcode" => true,
                "text" => $text
            ];
        }
    }

    public static function substr_slip_ref($json)
    {
        $output_1 = substr($json, 25);
        $ref = substr($output_1, 0, -14);

        return $ref;
    }

    public static function generate_maemanee_promptpay($amount = 0)
    {
        $first = "00020101021230770016A000000677010112011501075360001028602150140000048953630315PUNPANGPRANBURI5802TH540";
        $amount = number_format($amount, 2, '.', '');
        $countAmount = strlen($amount);
        $last = "53037646220071600000000007066306304";
        $code = $first . $countAmount . $amount . $last;
        $xFFFF = dechex(Helper::CRC16Normal($code));
        $full = Str::upper($code . $xFFFF);
        return $full;
    }

    public static function generate_phone_promptpay($amount = 0, $phone = "66918853402")
    {
        if (str_starts_with($phone, "0") && strlen($phone) == 10) {
            // unset($phone[0]);
            $phone[0] = "6";
            $phone = "6" . $phone;
        } else if (strlen($phone) == 11 && str_starts_with($phone, "66")) {
        } else {
            return;
        }

        $first = "00020101021153037645802TH29370016A000000677010111011300" . $phone . "540";
        $amount = number_format($amount, 2, '.', '');
        $countAmount = strlen($amount);
        $last = "6304";
        $code = $first . $countAmount . $amount . $last;
        $xFFFF = dechex(Helper::CRC16Normal($code));
        $full = Str::upper($code . $xFFFF);
        return $full;
    }

    public static function generate_qrcode_text($text = null)
    {
        if ($text == null) return;

        $qr_code = QrCode::size(300)->format("png")->generate($text);
        $name_unique = Helper::randomNumber();
        file_put_contents("images/qr-code/$name_unique.png", $qr_code);
        // $url = URL::base() . "/images/qr-code/$name_unique.png";

        return "images/qr-code/$name_unique.png";
    }

    public static function unlink_url($url = null)
    {
        if ($url == null) return;

        $path = strlen(URL::base());
        $unlink = substr($url, $path, strlen($url) - $path);
        unlink($unlink);

        return;
    }

    public static function verify_slip($qr_code_text = null)
    {
        if (is_null($qr_code_text)) {
            return [
                "verify" => false,
                "message" => "ไม่มีข้อมูล qr_code_text"
            ];
        }

        $url = "https://myslip.me/api/v1/verify";
        $token = "09c29119-ccac-493c-bd7c-7301e44fe0e5";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
             "data": "' . $qr_code_text . '"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $slip = json_decode($response, true);
        // Linenotify::send("asfjasjmfp");
        // Linenotify::send($slip);


        if ($slip["status"] != "200") {
            Linenotify::send("CHECK_SLIP [ Helper::verify_slip() ] --> STATUS [ " . $slip["status"] . " ] --> MESSAGE [ " . $slip["message"] . " ]");

            // if ($slip["message"] == "not_enough_credit") {
            //     Linenotify::send("Check_Slip ==> เครดิตไม่เพียงพอ");
            // }
            return [
                "verify" => false,
                "message" => "สถานะไม่ถูกต้อง",
            ];
        }

        $transRef = $slip["message"]["data"]["transRef"];
        $date = \Carbon\Carbon::parse($slip["message"]["data"]["date"])->format("Y-m-d H:i:s");
        $amount = $slip["message"]["data"]["amount"];
        $receiver = $slip["message"]["data"]["receiver"];
        // $sender = $slip["message"]["data"]["sender"];

        $allowed_bank_accounts = [
            // "0141111111111", // scb pp
            // "xxxx-xx154-9", // scb bka
            // "xxx-xxx-3402", // scb pp
            // "xxx-x-x8154-x", // k+ bka
            // "XXXXXX3402", // ktc pp
            // "XXX-X-XX154-9", // ktc bka
            // "419-1-xxx549", // bbl bka
            // "091-xxx-3402", // bbl pp
            // "09xxxx3402", // gsb pp
            // "41xxxx1549", // gsb bka
            "4191081549", // ttb bka
            "0918853402", // bay pp
        ];

        foreach ($allowed_bank_accounts as $allowed_bank_account) {
            similar_text($allowed_bank_account, $receiver["account"], $percent_bank_account);
            // Linenotify::send("NAME =>" . $receiver["name"] . " || ACCOUNT => " . $receiver["account"]);

            if ($percent_bank_account == 100) {
                // AllowedCheckSlip::firstOrCreate(["key" => $receiver["name"]]);
                // AllowedCheckSlip::firstOrCreate(["key" => $receiver["account"]]);
                //                 Linenotify::send("
                // ตรวจสอบจากเลขบัญชี
                // NAME : " . $receiver["name"] . "
                // ACCOUNT : " . $receiver["account"] . "
                // BANK_NAME : " . $sender["bank"]["name"]);

                return [
                    "verify" => true,
                    "message" => "ตรวจสอบผ่าน",
                    "transRef" => $transRef,
                    "amount" => $amount,
                    "date" => $date,
                    "data" => $slip["message"]["data"]
                ];
            }
        }

        $allowed_names = [
            "นางสาว ฐิติภัทร ศรีสุข",
            // "น.ส.ฐิติภัทร ศรีสุข",
            // "ฐิติภัทร ศรีสุข",
            // // "ฐิติภัทร"
            // "TITIPAT SRISUK",
            "TITIPAT SRISU"
        ];

        foreach ($allowed_names as $allowed_name) {
            similar_text($allowed_name, $receiver["name"], $percent_name);
            // Linenotify::send("NAME =>" . $receiver["name"] . " || ACCOUNT => " . $receiver["account"]);

            if ($percent_name == 100) {
                // AllowedCheckSlip::firstOrCreate(["key" => $receiver["name"]]);
                // AllowedCheckSlip::firstOrCreate(["key" => $receiver["account"]]);
                //                 Linenotify::send("
                // ตรวจสอบจากชื่อบัญชี
                // NAME : " . $receiver["name"] . "
                // ACCOUNT : " . $receiver["account"] . "
                // BANK_NAME : " . $sender["bank"]["name"]);

                return [
                    "verify" => true,
                    "message" => "ตรวจสอบผ่าน",
                    "transRef" => $transRef,
                    "amount" => $amount,
                    "date" => $date,
                    "data" => $slip["message"]["data"]
                ];
            }
        }



        Linenotify::send("ตรวจสอบสลิป --> ชื่อบัญชีหรือเลขที่บัญชีอาจไม่ถูกต้อง --> " . $receiver["name"] . " : " . $receiver["account"] . " --> Helper::verify_slip()");
        // Linenotify::send($slip);

        return [
            "verify" => false,
            "message" => "ไม่ผ่านการตรวจสอบ",
            "transRef" => $transRef,
            "amount" => $amount,
            "date" => $date,
            "data" => $slip["message"]["data"]
        ];

        similar_text("นางสาว ฐิติภัทร ศรีสุข", $receiver["name"], $percent_name);

        if ($percent_name >= 100) {
            return [
                "verify" => true,
                "message" => "ตรวจสอบผ่าน",
                "transRef" => $transRef,
                "amount" => $amount,
                "date" => $date,
                "data" => $slip["message"]["data"]
            ];
        } else if ($percent_name <= 80) {
            Linenotify::send("ตรวจสอบสลิป <= 80%");
            Linenotify::send($slip);
            return [
                "verify" => false,
                "message" => "ไม่ผ่านการตรวจสอบ",
                "transRef" => $transRef,
                "amount" => $amount,
                "date" => $date,
                "data" => $slip["message"]["data"]
            ];
        } else {
            Linenotify::send("ตรวจสอบสลิป > 80% < 100%");
            Linenotify::send($slip);

            return [
                "verify" => false,
                "message" => "ไม่ผ่านการตรวจสอบ",
                "transRef" => $transRef,
                "amount" => $amount,
                "date" => $date,
                "data" => $slip["message"]["data"]
            ];
        }
    }

    public static function verify_slip_v2($qr_code_text = null)
    {
        if (is_null($qr_code_text)) {
            return [
                "verify" => false,
                "message" => "ไม่มีข้อมูล qr_code_text"
            ];
        }

        $url = "https://api.slipok.com/api/line/apikey/4979";
        $token = "SLIPOKCFRUR8F";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
               "data" : "' . $qr_code_text . '"
          }',
            CURLOPT_HTTPHEADER => array(
                'x-authorization: ' . $token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $slip = json_decode($response, true);
        // Linenotify::send("asfjasjmfp");
        // Linenotify::send($slip);


        if ($slip["success"] != true) {
            Linenotify::send("CHECK_SLIP [ Helper::verify_slip_() ] --> STATUS [ " . $slip["success"] . " ] --> MESSAGE [ " . $slip["data"]["message"] . " ]");

            // if ($slip["message"] == "not_enough_credit") {
            //     Linenotify::send("Check_Slip ==> เครดิตไม่เพียงพอ");
            // }
            return [
                "verify" => false,
                "message" => "สถานะไม่ถูกต้อง",
            ];
        }

        $transRef = $slip["data"]["transRef"];
        // $date = \Carbon\Carbon::parse($slip["data"]["transDate"])->format("Y-m-d") . " " . $slip["data"]["transTime"];
        $transDate = $slip["data"]["transDate"];
        $date =  $transDate[0] . $transDate[1] . $transDate[2] . $transDate[3] . "-" . $transDate[4] . $transDate[5] . "-" . $transDate[6] . $transDate[7] . " " . $slip["data"]["transTime"];
        $amount = $slip["data"]["amount"];
        $receiver = $slip["data"]["receiver"];
        // $sender = $slip["message"]["data"]["sender"];

        $allowed_bank_accounts = [
            // "0141111111111", // scb pp
            // "xxxx-xx154-9", // scb bka
            // "xxx-xxx-3402", // scb pp
            // "xxx-x-x8154-x", // k+ bka
            // "XXXXXX3402", // ktc pp
            // "XXX-X-XX154-9", // ktc bka
            // "419-1-xxx549", // bbl bka
            // "091-xxx-3402", // bbl pp
            // "09xxxx3402", // gsb pp
            // "41xxxx1549", // gsb bka
            "4191081549", // ttb bka
            "0918853402", // bay pp


            "xxxx-xx154-9", // scb bka
            "xxx-xxx-3402", // scb pp

            "XXXXXX3402", // ktb pp
            "XXX-X-XX154-9", // ktb bak

            "xxx-xxx-3402", // TTB PP

            "xxx-x-x8154-x", // kbank pp
            "xxx-x-x8154-x", //kbank bka

            "09xxxx3402", //gsb pp

        ];

        foreach ($allowed_bank_accounts as $allowed_bank_account) {
            similar_text($allowed_bank_account, $receiver["account"]["value"], $percent_bank_account);
            similar_text($allowed_bank_account, $receiver["proxy"]["value"], $percent_proxy);
            // Linenotify::send("NAME =>" . $receiver["name"] . " || ACCOUNT => " . $receiver["account"]);

            if ($percent_bank_account == 100 || $percent_proxy == 100) {
                // AllowedCheckSlip::firstOrCreate(["key" => $receiver["name"]]);
                // AllowedCheckSlip::firstOrCreate(["key" => $receiver["account"]]);
                //                 Linenotify::send("
                // ตรวจสอบจากเลขบัญชี
                // NAME : " . $receiver["name"] . "
                // ACCOUNT : " . $receiver["account"] . "
                // BANK_NAME : " . $sender["bank"]["name"]);

                return [
                    "verify" => true,
                    "message" => "ตรวจสอบผ่าน",
                    "transRef" => $transRef,
                    "amount" => $amount,
                    "date" => $date,
                    "data" => $slip["data"]
                ];
            }
        }

        $allowed_names = [
            "นางสาว ฐิติภัทร ศรีสุข",
            "นางสาว ฐิติภัทร ศ",

            // "น.ส.ฐิติภัทร ศรีสุข",
            // "ฐิติภัทร ศรีสุข",
            // // "ฐิติภัทร"
            // "TITIPAT SRISUK",
            "TITIPAT SRISU",
            "TITIPAT S"

        ];

        foreach ($allowed_names as $allowed_name) {
            similar_text($allowed_name, $receiver["name"], $percent_name);
            // Linenotify::send("NAME =>" . $receiver["name"] . " || ACCOUNT => " . $receiver["account"]);

            similar_text($allowed_name, $receiver["displayName"], $percent_displayName);

            if ($percent_name == 100 || $percent_displayName == 100) {
                // AllowedCheckSlip::firstOrCreate(["key" => $receiver["name"]]);
                // AllowedCheckSlip::firstOrCreate(["key" => $receiver["account"]]);
                //                 Linenotify::send("
                // ตรวจสอบจากชื่อบัญชี
                // NAME : " . $receiver["name"] . "
                // ACCOUNT : " . $receiver["account"] . "
                // BANK_NAME : " . $sender["bank"]["name"]);

                return [
                    "verify" => true,
                    "message" => "ตรวจสอบผ่าน",
                    "transRef" => $transRef,
                    "amount" => $amount,
                    "date" => $date,
                    "data" => $slip["data"]
                ];
            }
        }

        Linenotify::send("ตรวจสอบสลิป --> ชื่อบัญชีหรือเลขที่บัญชีอาจไม่ถูกต้อง --> " . $receiver . " --> Helper::verify_slip()");
        // Linenotify::send($slip);

        return [
            "verify" => false,
            "message" => "ไม่ผ่านการตรวจสอบ",
            "transRef" => $transRef,
            "amount" => $amount,
            "date" => $date,
            "data" => $slip["data"]
        ];

        similar_text("นางสาว ฐิติภัทร ศรีสุข", $receiver["name"], $percent_name);

        if ($percent_name >= 100) {
            return [
                "verify" => true,
                "message" => "ตรวจสอบผ่าน",
                "transRef" => $transRef,
                "amount" => $amount,
                "date" => $date,
                "data" => $slip["message"]["data"]
            ];
        } else if ($percent_name <= 80) {
            Linenotify::send("ตรวจสอบสลิป <= 80%");
            Linenotify::send($slip);
            return [
                "verify" => false,
                "message" => "ไม่ผ่านการตรวจสอบ",
                "transRef" => $transRef,
                "amount" => $amount,
                "date" => $date,
                "data" => $slip["message"]["data"]
            ];
        } else {
            Linenotify::send("ตรวจสอบสลิป > 80% < 100%");
            Linenotify::send($slip);

            return [
                "verify" => false,
                "message" => "ไม่ผ่านการตรวจสอบ",
                "transRef" => $transRef,
                "amount" => $amount,
                "date" => $date,
                "data" => $slip["message"]["data"]
            ];
        }
    }

    public static function cut_comma_to_numeric($string)
    {
        $e1 = explode(",", $string);
        $n = "";
        foreach ($e1 as $e) {
            $n = "$n$e";
        }

        return number_format($n, 0, "", "");
    }

    public static function get_params_url($url)
    {
        $parse_url = parse_url($url);

        $ex1 = explode("&", $parse_url["query"]);
        // $params = [];
        foreach ($ex1 as $ex2) {
            $ex3 = explode("=", $ex2);
            $params[$ex3[0]] = $ex3[1];
        }

        $parse_url["params"] = $params;
        $parse_url["url"] = $url;
        return $parse_url;
    }

    public static function temporarySignedRouteUrl($name, $expires, $params = [])
    {

        $url =  URL::temporarySignedRoute(
            $name,
            $expires,
            $params
        );

        return $url;
    }
}
