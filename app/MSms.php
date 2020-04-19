<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sms;
use App\Linenotify;

class MSms extends Model
{

  public static function Sms($p,$m)
  {
    $key = MSms::LCKEY();
    $MSms = MSms::LCSms($p,$m,$key);
    if ($MSms['status'] == 200) {
      return 200;
    }elseif ($MSms['status'] == 400) {
      (new Linenotify)->line('แจ้งเตือน : ระบบ SMS ไม่ทำงาน กรุณาเปิดปิดแอพใหม่ !');
      $sms = Sms::send([$p],$m);
      if ($sms['code'] != 200) {
        // return 400;
        return $sms['code'];
      }
    }

  }

  public static function LCURL()
  {
    return config('message.LCSms.url');
  }

  public static function LCKEY()
  {
    return config('message.LCSms.key');
  }

  public static function LCSms($number,$message,$key)
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
        CURLOPT_TIMEOUT => 30,
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
