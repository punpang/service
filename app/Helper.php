<?php

namespace App;

// use Carbon\Carbon;
// use Google\Service\HangoutsChat\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Zxing\QrReader;

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
        $url_new = str_replace("&", "%26", $url);
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://api.qrserver.com/v1/read-qr-code/?fileurl=" . $url_new);
        $result = json_decode($response->getBody(), true);
        return $result;
        // $result[0]["symbol"][0]["data"]
    }

    public static function qrCodeReaderUrl_v2($url)
    {
        // Linenotify::send("qrCodeReaderUrl_v2 $url");
        // $path_to_image = "https://scontent.xx.fbcdn.net/v/t1.15752-9/320485838_707703987368960_3814132955435592475_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=58c789&_nc_ohc=LttICDvKvvcAX_vPtRP&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdQ0V0B9299hGIuyBXGNkcHZmHAsDnzTekBWxsPy0hLbgg&oe=63C73566";
        $qrcode = new QrReader($url);
        $text = $qrcode->text();
        return $text;
    }

    public static function substr_slip_ref($json)
    {
        $output_1 = substr($json, 25);
        $ref = substr($output_1, 0, -14);

        return $ref;
    }
}
