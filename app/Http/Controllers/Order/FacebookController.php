<?php

namespace App\Http\Controllers\Order;

use App\Linenotify;
use App\Order\Setting;
use App\Order\Facebook;
use App\Order\FacebookMids;
use Illuminate\Http\Request;
use App\Order\FacebookWebhook;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FacebookController extends Controller
{
    public function webhook(Request $request)
    {
        $setting = Setting::first();
        if (!$setting->facebook_status_bot || $request->method() == "GET") {
            Linenotify::send("Facebook Status Bot :: Off");
            return $request["hub_challenge"];
        }

        $input = json_decode($request->getContent(), true);

        if (FacebookMids::check($input['entry'][0]['messaging'][0]['message']['mid'])) {
            Linenotify::send($request->getContent());
            return $request["hub_challenge"];
        }

        // PSID ของลูกค้า
        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];

        // สร้างโปรไฟล์ลูกค้า สำหรับผูกสมาชิกต่อไป และอัปเดทคุยล่าสุด
        $profile = Facebook::create_profile($sender);

        // ตรวจสอบว่าทักครั้งแรกหรือไม่
        if ($profile->welcome_date != now()->format('Y-m-d')) {
            Facebook::welcome_date($profile);
        }

        // นอกเวลาทำการ
        if (
            now()->format("H:i") >= $setting->close_store ||
            now()->format("H:i") <= $setting->open_store
        ) {
            $message_out = "ขณะนี้ ! อยู่นอกเวลาทำการ โปรดติดต่ออีกครั้งในช่วงเวลาทำการ ($setting->open_store - $setting->close_store น.) ขออภัยในความไม่สะดวก

**ทุกข้อความตอบกลับโดยระบบอัตโนมัติ";
            Facebook::reply_message_v2($sender, $message_out);
            return $request["hub_challenge"];
        }

        // มีข้อความไหม --เป็นตัวหนังสือ--
        if (!empty($input['entry'][0]['messaging'][0]['message']['text'])) {
            $message = $input['entry'][0]['messaging'][0]['message']['text'];

            Facebook::update_profile_by_message($profile, $message);

            // สมัครสมาชิก
            // if (
            //     str_starts_with($message, "สมัครสมาชิก") &&
            //     Facebook::register_member($sender, $message)
            // ) {
            //     return $request["hub_challenge"];
            // }

            // สร้างคำที่ยังไม่มีในฐานข้อมูล พร้อมดึงข้อมูลออกมา
            $FacebookWebhook = FacebookWebhook::firstOrCreate([
                "message" => $message,
            ]);

            // ตอบข้อความที่ตรงกับฐานข้อมูล
            if ($FacebookWebhook->reply) {
                Facebook::reply_message_v2($sender, $FacebookWebhook->reply->text_th);
            }

            // ตอบคะแนนของลูกค้า
            // if ($message == "คะแนนของฉัน") {
            //     Facebook::sumCustomerScore($profile, $sender);
            //     // return $request["hub_challenge"];
            // }
        }

        // มี POSTBACK
        // if (!empty($input['entry'][0]['messaging'][0]['postback']['payload'])) {
        //     $postback = json_decode($input['entry'][0]['messaging'][0]['postback']['payload'], true);
        //     Facebook::key_word_postback($sender, $postback);
        // }

        return $request["hub_challenge"];
    }

    public function search_profile(Request $request)
    {
        $datas = Facebook::query();

        if ($request->get("name") != "undefined") {
            $explodeName = explode(" ", $request->get("name"));
            if (!isset($explodeName[1])) {
                $datas->where("first_name", "like",  '%' . $explodeName[0] . '%')
                    ->orWhere("last_name", "like",  '%' . $explodeName[0] . '%');
                // $datas->where("last_name", "like",  '%' . $explodeName[0] . '%');
            } else {
                $datas->where("first_name", "like",  '%' . $explodeName[0] . '%')
                    ->orWhere("last_name", "like",  '%' . $explodeName[1] . '%');
            }
        }

        if ($request->get("isNullCustomer") != "undefined") {
            if ($request->get("isNullCustomer") == true) {
                $datas->whereNull("customer_id");
            }
        }

        return $datas->get();
    }

    public function connect_profile(Facebook $profile, Request $request)
    {
        $count = Facebook::where("customer_id", $request->customer_id)->count();
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

    public function disconnect_profile(Facebook $profile, Request $request)
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

    public function hash_hmac()
    {
        $access_token = "EAAKZBZBHAEHQ8BAF4SC7ZCC9G4lVHhVaxnwAOiJfRCsdamI7gD0uw94qBd9xRTX1v1Fyh70dReNVciZAGIjJgmEyVHPq0EcANk9rRyrSnGT6ZALXRZA7ehr7WGBjZCmsZC93NBljic2KzZCBLJBKYC1tbUuwSWynn0TfC1E0huCCxICn6tvHKqCYVyY7lwFrL3yxJBNXNLiYtUwZDZD";
        $app_secret = "eed783a0f3a5af01a97444063b3ddbb7";
        $appsecret_proof =  hash_hmac('sha256', $access_token, $app_secret);
        $psid = "1291750900924146";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v14.0/' . $psid . '/ids_for_apps?app=772924193905935&access_token=' . $access_token . '&appsecret_proof=' . $appsecret_proof,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function save_image_base64()
    {
        $base64 = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAXIAAAFyAQAAAADAX2ykAAACoElEQVR4nO2aTWrkMBBGX40FWaohB+ijqG82zJFyA/soOcCAtWyQ+WYhqdOdMJMOOKY9VC0MRm/xQVE/KpWJr9j040s4OO+8884777zzf+OtWaB/zJgOALmfnTbU4/zKfJIkzbdn2QwYJEm65b9bj/Mr87lHaJqX6lXSDHaCGtMb63F+HT68+9d0LIH0cjCIAvK2epxfl3/vX0szYjqWILLx4Xb8aPqd/7d1//ZYbQ7NTzKisPTCjZMfTb/zd/GTmZkdwE45YD9nIL0GgKW2z9vqcX4lvsbvW4RqOhZEXkzkpRfh7fQ4vy5Pvfwklfaf+l1II4MgqnbS9Qo1Ppp+5+/hNeYnaYwS5ABpHgTxbNK8GMSCxg31OL8ub3Y8Wx1oTMcCsFh1chtiPfl8Y8+8RsBOsSC9tl7K7AA1nKfj2eeT++Rr/dUYr+eTNRcnlZqpNcbSuUfT7/wn1vwGtDIbJUmlN1T1QPL+apf8pX+WaqxqBtIM0kx1dzt1/+6Qb/ffyUBwNhFL0HQASy9DMQhFk134R9Pv/CfW629BmodLai43hfliHr8746/yc7dy5fM+7hjcv/vkm3/fxlTE3lVdTa28v9or39+PcihMRwEsQcTfQeShWCu9lwL8aPqdv4+PZ4McMDsMshOX+Qb0ceWmepxfk79qrcgBYJDGeLZWf+PZfP68Y/5tf7K2ziNLz8jd3ZvqcX4tvtXfNALkZ4AlQBxkRIBYnxuCttHj/Pfwl/3J9la0tIQ89U3odvqo+p2/l4/lspozqM6k5f3V/8Lr1wHaI3DuL4Wn7PtXO+Xf709WS+OCpfm5QA7Um/A2epxfl2/+bWOMAUuvobRkHM8GDKUm6W30OL8u/2F/Egq0C9HwYb394fQ777zzzjvv/B75P230m3hnLMGVAAAAAElFTkSuQmCC";
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        // file_put_contents('/storage/images/text.png', $data);

        // $image = str_replace('data:image/png;base64,', '', $image);
        // $image = str_replace(' ', '+', $image);
        // $imageName = "textTest" . '.' . 'png';
        // Storage::put('/app/public/images/qrcode/1.png', $data);
        Storage::put('file.png', $data, 'public');
        // Storage::disk('public')->put($imageName, $data);
        return $data;
    }
}
