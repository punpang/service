<?php

namespace App\Http\Controllers\Order;

use PDO;
// use Zxing\QrReader;
use App\URL;
use App\Helper;
use App\Linenotify;
use App\Order\AOrder;
use App\Order\Setting;
use App\Order\Facebook;
use App\Order\KsherPay;
use App\Order\FacebookMids;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Order\FacebookImages;
use App\Order\FacebookWebhook;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\FacebookImagesAlertPaymentJob;

// use SimpleSoftwareIO\QrCode\Facades\QrCode;


class FacebookController extends Controller
{
    public function webhook(Request $request)
    {
        // $token = "fdh5j41f65hg1aw6fg1h6jkl1hj65k1j6d5gs165i165re1d65fsd1x6j5nmk165try1r65qaw1gvf65z1h65sr16yg";
        // if ($request["hub_verify_token"] != $token) {

        //     Linenotify::send("hub_verify_token ไม่ถูกต้อง => " . $request);
        //     return $request["hub_challenge"];
        // }

        $setting = Setting::first();
        if (!$setting->facebook_status_bot || $request->method() == "GET") {
            Linenotify::send("Facebook Status Bot :: Off");
            return $request["hub_challenge"];
        }


        $input = json_decode($request->getContent(), true);

        if (isset($input['entry'][0]['messaging'][0]['message']['mid'])) {
            if (FacebookMids::check($input['entry'][0]['messaging'][0]['message']['mid'])) {
                Linenotify::send($request->getContent());
                return $request["hub_challenge"];
            }
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

        $is_time_close_store = now()->format("H:i") >= $setting->close_store || now()->format("H:i") <= $setting->open_store;
        if (
            $is_time_close_store
            // now()->format("H:i") >= $setting->close_store ||
            // now()->format("H:i") <= $setting->open_store
        ) {
            $message_out = "ขณะนี้ ! อยู่นอกเวลาทำการ โปรดติดต่ออีกครั้งในช่วงเวลาทำการ ($setting->open_store - $setting->close_store น.) ขออภัยในความไม่สะดวก

**ทุกข้อความตอบกลับโดยระบบอัตโนมัติ";
            Facebook::reply_message_v2($sender, $message_out);
            // return $request["hub_challenge"];
        }

        // มีข้อความไหม --เป็นตัวหนังสือ--
        if (!empty($input['entry'][0]['messaging'][0]['message']['text'])) {
            $message = $input['entry'][0]['messaging'][0]['message']['text'];

            Facebook::update_profile_by_message($profile, $message);

            Facebook::register_wongnai_pos_bill($message, $profile);

            // สมัครสมาชิก
            if (
                str_starts_with($message, "สมัครสมาชิก") &&
                Facebook::register_member($sender, $message)
            ) {
                return $request["hub_challenge"];
            }

            // สร้างคำที่ยังไม่มีในฐานข้อมูล พร้อมดึงข้อมูลออกมา
            $FacebookWebhook = FacebookWebhook::firstOrCreate([
                "message" => $message,
            ]);

            // ตอบข้อความที่ตรงกับฐานข้อมูล
            if ($FacebookWebhook->reply && !$is_time_close_store) {
                Facebook::reply_message_v2($sender, $FacebookWebhook->reply->text_th);
            }

            // ตอบคะแนนของลูกค้า
            if ($message == "คะแนนของฉัน") {
                Facebook::sumCustomerScore($profile, $sender);
                // return $request["hub_challenge"];
            }
        }

        // มี Image
        if (!empty($input['entry'][0]['messaging'][0]['message']['attachments'])) {
            $attachments = $input['entry'][0]['messaging'][0]['message']['attachments'];
            // Facebook::payment_by_facebook_image($attachments, $profile);
            FacebookImages::createImages($attachments, $profile);
            // foreach ($attachments as $attachment) {
            //     if ($attachment["type"] == "image") {
            //         FacebookImages::createImage($attachment, $profile);
            //         // $attachment["payload"]["url"];
            //         // FacebookImagesAlertPaymentJob::dispatch();
            //     }
            // }
            // Artisan::queue('FacebookImages:AlertPaymentCommand');
        }

        // มี POSTBACK
        if (!empty($input['entry'][0]['messaging'][0]['postback']['payload'])) {
            $postback = json_decode($input['entry'][0]['messaging'][0]['postback']['payload'], true);
            Facebook::key_word_postback($sender, $postback);
        }

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

        $datas->orderBy("updated_at", "DESC")->orderBy("customer_id", "ASC");

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

    public function set_qrcode_payment(AOrder $order)
    {
        Linenotify::send("set_qrcode_payment");
        // $payload = [
        //     "keyword" => "genarate_qrcode_promtpay_to_facebook",
        //     "order_id" => $order->id,
        // ];


        // Facebook::send_postback(
        //     $order,
        //     [
        //         [
        //             "title" => "ทดสอบ QRCODE",
        //             "buttons" => [
        //                 [
        //                     "title" => "สร้าง QR CODE ชำระเงิน",
        //                     "payload" => json_encode($payload),
        //                     "type" => "postback"
        //                 ]
        //             ]
        //         ]
        //     ]
        // );
        // return;

        $base64 = KsherPay::create_qrcode_promptpay_by_facebook($order);

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $unique = Str::uuid();
        file_put_contents("images/qr-code/$unique.png", $data);
        $url = URL::base() . "/images/qr-code/$unique.png";

        Facebook::send_reply_image($order, $url);
        $msg = "ชำระด้วยยอด " . number_format($order->sumBalance(), 2) . " บาท
------------------------------
QR CODE นี้ จะหมดอายุ
" . now()->addMinutes(10)->format("d/m/y H:i:s") . " น.
------------------------------
*ใช้ QR CODE พร้อมเพย์นี้ เพื่อชำระเงินได้เลยค่ะ*
**หลังจากลูกค้าชำระเงินแล้ว ทางร้านสงวนสิทธิ์ว่าลูกค้าได้ทำการตรวจสอบรายการสั่งซื้อแล้ว และรายการสั่งซื้อนั้นถูกต้อง**";
        Facebook::send_reply_message($order, $msg);

        unlink("images/qr-code/$unique.png");
        return response()->json([], 200);
    }

    public function test_sumup_message($order)
    {
        $order = AOrder::with(
            // "customer.facebook",
            // "customer.line",
            // "OrderChannel",
            // "am1",
            // "am2",
            // "am3",
            // "am4",
            "aStatus",
            // "aHistoryPayed.channelPayment",
            // "aHistoryPayed.ntpfc",
            // "aHistoryPayed.ksherPay",
            // "orderDetails.aPrice.googleImage",
            // "orderDetailsOnlyTrashed",
            // "orderDetails.productPrototypes.googleImage",
            // "orderDetails.imageForMenus.googleImage",
            // "orderDetails.imageFromCustomers.googleImage",
            // "orderDetails.imageGoodsReviewToCustomers.googleImage",
            // "orderDetails.orderTags.tag",
            "orderDeliveryService",
            "orderDetails.MoneyServices.category_money_service",
            "adjustExcessPayments",
            "posOrders.posGoods"
        )
            ->with("orderDetails.addOns.productAddOn.goodsAddOn")
            ->findOrFail($order);

        if ($order->sumMoneyCustomer() > 0 || $order->orderDeliveryService) {
            $order->update(["status_full_payment" => 1]);
        }




        $m = "";
        foreach ($order->orderDetails as $key_detail => $detail) {
            $a = "";
            foreach ($detail->addOns as $key => $addOn) {
                $a = $a . $addOn->productAddOn->goodsAddOn->name . ($key + 1 != $detail->addOns->count() ? " ," : "");
            }
            if ($a) {
                $aa = "
เพิ่มเติม : $a";
            } else {
                $aa = "";
            }


            if ($detail->moneyServices->count() > 0) {
                $ms = "";
                foreach ($detail->moneyServices as $key_moneyService => $moneyService) {
                    $ms = $ms . "
" . ($key_moneyService + 1) . ".บริการ : " . $moneyService->category_money_service->text . "
฿20x" . $moneyService->thb20 . " ฿50x" . $moneyService->thb50 . " ฿100x" . $moneyService->thb100 . "
฿500x" . $moneyService->thb500 . " ฿1,000x" . $moneyService->thb1000 . "
จำนวนเงิน : " . $moneyService->sum_money_format . " บาท
ค่าบริการ : " . number_format($moneyService->category_money_service->fee, 2) . " บาท";
                }

                $message_money_services = "

บริการเกี่ยวกับเงิน $ms";
            } else {
                $message_money_services = "";
            }

            /////
            $message = $detail->message != "-" ? "
ข้อความ : " . $detail->message : "";
            $remark = $detail->detail != "-" ? "
หมายเหตุ : " . $detail->detail : "";
            ////
            $m = $m . "รายการที่ " . ($key_detail + 1) . "
" . $detail->aPrice->name_goods  . $aa .  $message . $remark . "
ราคา " . number_format($detail->sum_total, 2) . " บาท $message_money_services
-------------------------
";
        }

        $message_pos = "";
        if ($order->posOrders->count() > 0) {
            foreach ($order->posOrders as $pos) {
                $message_pos = $message_pos . "
" . $pos->posGoods->text . "
฿" . number_format($pos->price, 2) . " x " . $pos->quantity . " = ฿" . number_format($pos->total, 2);
            }
            $message_pos = $message_pos . "
รวม " . number_format($order->sumPosOrder(), 2) . " บาท

-------------------------";
        }

        if ($order->orderDeliveryService) {
            $message_delivery_service = "บริการจัดส่ง
ชื่อผู้รับ : " . $order->orderDeliveryService->recipient_name . "
เบอร์โทรผู้รับ : " . $order->orderDeliveryService->recipient_phone . "
วัน-เวลาจัดส่งถึงโดยประมาณ :
" . $order->date_get_th . " " . $order->time_get_format . " - " . \Carbon\Carbon::createFromFormat("H:i", $order->time_get_format)->addMinutes(30)->format("H:i") . " น.
สถานที่จัดส่ง : " . $order->orderDeliveryService->link_google_maps . "
ค่าบริการ : " .  number_format($order->orderDeliveryService->delivery_fee, 2) . " บาท
-------------------------
";
        } else {
            $message_delivery_service = "";
        }


        $msg = "หมายเลขคำสั่งซื้อ #$order->id
ชื่อลูกค้า : " . $order->customer->name . "
เบอร์โทร : " . $order->customer->tel . "
-------------------------
วัน-เวลารับสินค้า
" . $order->date_time_get_th . " น.
-------------------------
" . $m . $message_pos . "
" . $message_delivery_service . "ยอดทั้งหมด " . number_format($order->sumTASC()) . " บาท
ยอดชำระแล้ว " . number_format($order->sumDeposited()) . " บาท
-------------------------
ยอดคงเหลือ " . number_format($order->sumBalance()) . " บาท
-------------------------
สถานะ : " . $order->aStatus->status . "
-------------------------
หลังจากลูกค้าชำระเงินแล้ว
ทางร้านสงวนสิทธิ์ลูกค้าตรวจสอบรายการสั่งซื้อแล้ว";

        Linenotify::send($msg);

        Facebook::send_reply_message($order, $msg);
        return $msg;
        return response()->json([
            "order" => $order,

            // "sumAll" => $order->sumAll(),
            // "setNameGoods" => $order->setNameGoods()
        ], 200);
    }

    public function readerqrcode()
    {
        // dd("sss");
        $result =  Helper::qrCodeReaderUrl_v2("https://lh3.googleusercontent.com/d/1cCQdMgMjOXjsoC2_3BkoXh_KX9vJ37vn");
        //

        // $generate_maemanee_promptpay = Helper::generate_maemanee_promptpay(100);
        // $generate_qrcode_text = Helper::generate_qrcode_text($generate_maemanee_promptpay);
        // unlink("$generate_qrcode_text");
        // unlink("images/qr-code/$unique.png");


        return $result;
    }

    public function get_bese64()
    {
        $b64image = base64_encode(file_get_contents('https://lh3.googleusercontent.com/d/1WXsIEycHHxe4YZ2s2tPUZQjOLqhvnoxO'));
        return $b64image;
    }

    public function aiforthai()
    {

        $order = AOrder::orderBy("updated_at", "DESC")->first();

        if ($order->orderDeliveryService) {
            return "มีบริการจัดส่ง";
        }

        return "ไม่มีบริการจัดส่ง";
        $slip_prototypes = [
            "https://scontent.xx.fbcdn.net/v/t1.15752-9/321386752_4117037548520850_2443181519936123893_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=58c789&_nc_ohc=iL6rD1KOreYAX9QR7qn&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdRk6Sj6I_qEBYYydvna3Vm9bPYMrxND7FpNJI6wV5YOHQ&oe=63D220A7",
            "https://lh3.googleusercontent.com/d/1zmFSxC7MpUhOddxdGntSiIORePVGCW_6",
            "https://scontent.xx.fbcdn.net/v/t1.15752-9/321685468_3212906642355711_1607434823650167392_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=58c789&_nc_ohc=r_qZAUlc3cgAX-p1qkv&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdSgRSY8nYjFwxyS1J7tdkiOrtanl_le6zRO95bUI8vieA&oe=63D22B68",
            "https://lh3.googleusercontent.com/d/1wSDbkDed5hnMcxzlY7rbUeA8tHBkj7P4",
            "https://scontent.xx.fbcdn.net/v/t1.15752-9/321997930_935476037421855_2273680509304431328_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=58c789&_nc_ohc=EiEfBnvm5nUAX-bdImH&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdRyMS8cosWba5v-DeXSeaebR-6VoRnmGozA-cLRDh6e1A&oe=63D1E6E5",
            "https://scontent.fkdt3-1.fna.fbcdn.net/v/t1.15752-9/316296557_680572783760954_6284968132752711889_n.png?_nc_cat=100&ccb=1-7&_nc_sid=ae9488&_nc_eui2=AeFAGLn9p8x0jR0C7ak2eYcCpsAXvKfqFfWmwBe8p-oV9QOlEJs9E_fPR0hcVgPJCgZeXWYjU0ewtjh9b9gMAPdr&_nc_ohc=ifB2iL7utjEAX-nWzi8&_nc_ht=scontent.fkdt3-1.fna&oh=03_AdReoVnDlTRxX7wqnj2u0QLQc7uEZ94Qkzi0Ljkn3VphbA&oe=63D31EF6"
            // "https://scontent.fkdt3-1.fna.fbcdn.net/v/t39.30808-6/316831294_5385943404848102_8910622798598044883_n.jpg?stp=cp1_dst-jpg&_nc_cat=105&ccb=1-7&_nc_sid=973b4a&_nc_eui2=AeFyFrwVgLoHkmEOXDHqyMx9n1UZa9NE-tefVRlr00T616TjsywhmYr8qzdjMJhVTHQ0IQEpXdxKdO3mmLZveKQT&_nc_ohc=7zPVzHvwhq4AX9hh0kI&_nc_ht=scontent.fkdt3-1.fna&oh=00_AfAwpiJ8s5TZ9XhMBWkG_1OKUlM-U-JRaiAGE8CwFlqJqw&oe=63B11B6A"
        ];

        // $slip = "https://lh3.googleusercontent.com/d/1cCQdMgMjOXjsoC2_3BkoXh_KX9vJ37vn";
        // $imagePath1 =
        // "https://scontent.xx.fbcdn.net/v/t1.15752-9/321386752_4117037548520850_2443181519936123893_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=58c789&_nc_ohc=iL6rD1KOreYAX9QR7qn&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdRk6Sj6I_qEBYYydvna3Vm9bPYMrxND7FpNJI6wV5YOHQ&oe=63D220A7";

        // $imagePath2 =
        //     "https://scontent.xx.fbcdn.net/v/t1.15752-9/321386752_4117037548520850_2443181519936123893_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=58c789&_nc_ohc=iL6rD1KOreYAX9QR7qn&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdRk6Sj6I_qEBYYydvna3Vm9bPYMrxND7FpNJI6wV5YOHQ&oe=63D220A7";

        // $imagePath3 =
        //     "https://scontent.fkdt3-1.fna.fbcdn.net/v/t1.15752-9/321301696_831493394611931_183852941793471914_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=ae9488&_nc_eui2=AeEnHXJ2TM-2nj_GVIc25CENkBJsxt_rSP6QEmzG3-tI_rgvcCKda2xgv55HZZpEdXp0aclUV4r3oNzlwM7ouixm&_nc_ohc=2qXk2e0U6cMAX-i5_91&_nc_ht=scontent.fkdt3-1.fna&oh=03_AdTcNYf9o5DC7daAfEK6QXRNOfSlwYL3L2vy613hwuGgMA&oe=63D3340F";

        // Create new Imagick object

        $percents = [];

        foreach ($slip_prototypes as $slip_prototype) {
            $prototpe = new \Imagick($slip_prototype);
            $slip = new \Imagick("https://lh3.googleusercontent.com/d/1cCQdMgMjOXjsoC2_3BkoXh_KX9vJ37vn");
            $percents[] = $prototpe->compareImageChannels(
                $slip,
                \Imagick::CHANNEL_ALL,
                \Imagick::METRIC_MEANABSOLUTEERROR
            );
            // dd($diff12);
        }

        dd($percents);
        $diff12 = $prototpe->compareImageChannels(
            $slip,
            \Imagick::CHANNEL_ALL,
            \Imagick::METRIC_MEANABSOLUTEERROR
        );

        dd($diff12);


        // $imagick1 = new \Imagick($imagePath1);
        // $imagick2 = new \Imagick($imagePath2);
        // $imagick3 = new \Imagick($imagePath3);

        // Use compareImageChannels() function to find
        // the difference between images
        $diff12 = $imagick1->compareImageChannels(
            $imagick2,
            \Imagick::CHANNEL_ALL,
            \Imagick::METRIC_MEANABSOLUTEERROR
        );

        $diff13 = $imagick1->compareImageChannels(
            $imagick3,
            \Imagick::CHANNEL_ALL,
            \Imagick::METRIC_MEANABSOLUTEERROR
        );

        // Print the difference in array
        // print_r($diff12);
        // print_r($diff13);

        dd($diff12, $diff13);

        return $diff12;

        // $a =  Helper::generate_phone_promptpay(77);
        // // dd($a);
        // $b = Helper::generate_qrcode_text($a);
        // return dd($a, $b);
        // 00020101021153037645802TH29370016A00000067701011101130066918853402540 8 99999.00 6304 D287
        // 00020101021153037645802TH29370016A00000067701011101130066918853402540 7 9999.00 6304 2BEB
    }

    public function check_slip()
    {
        $qr = Helper::qrCodeReaderUrl_v2("https://scontent.fkdt3-1.fna.fbcdn.net/v/t1.15752-9/324981173_836759107413326_1494315589568600085_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=ae9488&_nc_eui2=AeGAnCM_pdTAsY4aks_pSCnOT88oYTzaPpNPzyhhPNo-k9tAl1v0LJEwJUxfhEbgqcury9Utjz66qiDwKUvHhIrp&_nc_ohc=lc2bI2dHe3oAX94wyak&_nc_ht=scontent.fkdt3-1.fna&oh=03_AdTF5hc5ZZmRv4i5CzfMD9Jay6mQyxLYlStrZVjFNmR-rw&oe=63E75807");
        return $qr;
        Artisan::queue('FacebookImages:AlertPaymentCommand');
        return;
        $slip = Helper::verify_slip("0046000600000101030140225202212315HrxrtS8e9LSq4xIR5102TH91048BAE");

        dd($slip);
        return;
        $names = [
            "นางสาว ฐิติภัทร ศรีสุข",
            "นางสาว ฐิติภัทร ศ",
            "น.ส.ฐิติภัทร ศรีสุข",
            "นาง เพชรรัตน์ จันทร์คำแก้ว",
            "นาย ชรันดร์ กระแสสาย",
            "นาย ณัฐพงษ์ เรืองสว่าง",
            "นาย มานะ สมศักดิ์",
            "นาง พณารัตน์ ศรีสุข",
            "นางสาว มาริสา เกตุสาย",
            "น.ส.กานดา เชิดฉิ่ง",
            "น.ส.อภิชญา บุญศรี",
            "นางสาว นันทิยา เพชรประดับ",
            "นางอารีย์ นนธิจันทร์",
            "น.ส.อัจฉราพร จันทร์ลาด",
            "นาย ชนินทร์ ผูกศิริ",
            "น.ส.ฐิติภัทธ์ สานวน",
            "นางสาว พิชญา สุวรรณศิลป์",
            "นาย เรวัต พิมพ์ไทย",
            "นางสาว จริยา วงศ์พุทธิเดชา",
            "พ.ต. สมพล ศิริโภคานนท์",
            "นาง พันนิการ์ ชมสายพลายงาม"
        ];


        foreach ($names as $name) {
            // $e1 = explode(" ", $name);
            $names_true = [
                "นางสาว ฐิติภัทร ศรีสุข",
                "น.ส.ฐิติภัทร ศรีสุข",
                "ฐิติภัทร ศรีสุข",
                // "ฐิติภัทร"
                "TITIPAT SRISUK"
            ];
            foreach ($names_true as $name_true) {
                similar_text($name_true, $name, $percent_name);
                if ($percent_name >=  70 && $percent_name < 80) {
                    echo $name . " =======> " . $percent_name . " =======> $name_true <br>";
                }
                // if (
                //     $percent_name == 100 &&
                //     str_ends_with($name, "ศรีสุข") || str_ends_with($name, "SRISUK")

                // ) {
                //     echo "$name  ====>  $percent_name <==== $name_true<br><br>";
                // }
            }




            // similar_text("นางสาว ฐิติภัทร ศรีสุข", $name, $percent_name);
            // similar_text("ฐิติภัทร", $name, $percent_name);
            // similar_text("ศรีสุข", $name, $percent_name);
            // echo $name . "  <=========>  " . $percent_name . " <br>";
        }



        // $slips = [
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "236313167750I000002B9790",
        //                 "date" => "2022-12-29T13:01:13+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 13:01",
        //                 "amount" => 230,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "030",
        //                         "name" => "ธนาคารออมสิน",
        //                         "short" => "gsb",
        //                         "swiftCode" => "gsbathbk"
        //                     ],
        //                     "name" => null,
        //                     "account" => "0201xxxx9743"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "09xxxx3402"
        //                 ],
        //                 "ref1" => "<nil>",
        //                 "ref2" => "<nil>",
        //                 "ref3" => "<nil>"
        //             ]
        //         ]
        //     ],
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "2022122989521826",
        //                 "date" => "2022-12-29T12:59:29+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 12:59",
        //                 "amount" => 450,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "006",
        //                         "name" => "ธนาคารกรุงไทย",
        //                         "short" => "ktb",
        //                         "swiftCode" => "krththbk"
        //                     ],
        //                     "name" => "AREE NONTHICHUN",
        //                     "account" => "XXX-X-XX971-0"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "XXXXXX3402"
        //                 ],
        //                 "ref1" => "<nil>",
        //                 "ref2" => "<nil>",
        //                 "ref3" => "<nil>"
        //             ]
        //         ]
        //     ],
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "202212291101008134",
        //                 "date" => "2022-12-29T11:19:00+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 11:19",
        //                 "amount" => 480,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "011",
        //                         "name" => "ธนาคารทหารไทยธนชาต",
        //                         "short" => "ttb",
        //                         "swiftCode" => "tmbkthbk"
        //                     ],
        //                     "name" => "นาย ชนินทร์ ผูกศิริ",
        //                     "account" => "xxx-x-04588-x"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "4191081549"
        //                 ],
        //                 "ref1" => "",
        //                 "ref2" => "",
        //                 "ref3" => ""
        //             ]
        //         ]
        //     ],
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "012363085932BPP03256",
        //                 "date" => "2022-12-29T08:59:32+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 08:59",
        //                 "amount" => 480,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "004",
        //                         "name" => "ธนาคารกสิกรไทย",
        //                         "short" => "kbank",
        //                         "swiftCode" => "kasithbk"
        //                     ],
        //                     "name" => "MS. KANYANAT T",
        //                     "account" => "xxx-x-x2515-x"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "xxx-xxx-3402"
        //                 ],
        //                 "ref1" => "<nil>",
        //                 "ref2" => "<nil>",
        //                 "ref3" => "<nil>"
        //             ]
        //         ]
        //     ],
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "2022122815523223004759308",
        //                 "date" => "2022-12-28T15:52:00+07:00",
        //                 "date_human" => "28 ธ.ค. 2022, 15:52",
        //                 "amount" => 1050,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "002",
        //                         "name" => "ธนาคารกรุงเทพ",
        //                         "short" => "bbl",
        //                         "swiftCode" => "bkkbthbk"
        //                     ],
        //                     "name" => null,
        //                     "account" => "973-0-xxx218"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "091-xxx-3402"
        //                 ],
        //                 "ref1" => "",
        //                 "ref2" => "",
        //                 "ref3" => null
        //             ]
        //         ]
        //     ],

        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "012358184534APP04231",
        //                 "date" => "2022-12-24T18:45:34+07:00",
        //                 "date_human" => "24 ธ.ค. 2022, 18:45",
        //                 "amount" => 80,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "004",
        //                         "name" => "ธนาคารกสิกรไทย",
        //                         "short" => "kbank",
        //                         "swiftCode" => "kasithbk"
        //                     ],
        //                     "name" => "Mr. Charun G",
        //                     "account" => "xxx-x-x7814-x"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "073",
        //                         "name" => "ธนาคารแลนด์ แอนด์ เฮ้าส์",
        //                         "short" => "lhfg",
        //                         "swiftCode" => "lahrthb1"
        //                     ],
        //                     "name" => "นาง เพชรรัตน์ จันทร์คำแก้ว",
        //                     "account" => "xxx-xxx-9592"
        //                 ],
        //                 "ref1" => "<nil>",
        //                 "ref2" => "<nil>",
        //                 "ref3" => "<nil>"
        //             ]
        //         ]
        //     ]

        // ];

        // foreach ($slips as $key => $slip) {
        //     if ($slip["status"] != "200") {
        //         if ($slip["message"] == "not_enough_credit") {
        //             Linenotify::send("Check_Slip ==> เครดิตไม่เพียงพอ");
        //         }

        //         return [
        //             "verify" => false,
        //             "message" => "สถานะไม่ถูกต้อง",
        //         ];
        //     }

        //     $transRef = $slip["message"]["data"]["transRef"];
        //     $date = \Carbon\Carbon::parse($slip["message"]["data"]["date"])->format("Y-m-d H:i:s");
        //     $amount = $slip["message"]["data"]["amount"];
        //     $receiver = $slip["message"]["data"]["receiver"];
        //     similar_text("นางสาว ฐิติภัทร ศรีสุข", $receiver["name"], $percent_name);
        //     echo $receiver["name"] . "  <=========>  " . $percent_name . " <br>";
        //     if ($percent_name >= 100) {

        //         // return [
        //         //     "verify" => true,
        //         //     "message" => "ตรวจสอบผ่าน",
        //         //     "transRef" => $transRef,
        //         //     "amount" => $amount,
        //         //     "date" => $date,
        //         //     "data" => $slip["message"]["data"]
        //         // ];
        //     } else if ($percent_name <= 80) {
        //         // return [
        //         //     "verify" => false,
        //         //     "message" => "ไม่ผ่านการตรวจสอบ",
        //         //     "transRef" => $transRef,
        //         //     "amount" => $amount,
        //         //     "date" => $date,
        //         //     "data" => $slip["message"]["data"]
        //         // ];
        //     } else {

        //         // return [
        //         //     "verify" => false,
        //         //     "message" => "ไม่ผ่านการตรวจสอบ",
        //         //     "transRef" => $transRef,
        //         //     "amount" => $amount,
        //         //     "date" => $date,
        //         //     "data" => $slip["message"]["data"]
        //         // ];
        //     }
        // }



        return "ไม่มี";


        // $slips = [
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "KMA221228145115Aiq49Z1Ch3",
        //                 "date" => "2022-12-28T14:51:00+07:00",
        //                 "date_human" => "28 ธ.ค. 2022, 14:51",
        //                 "amount" => 200,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "025",
        //                         "name" => "ธนาคารกรุงศรีอยุธยา",
        //                         "short" => "bay",
        //                         "swiftCode" => "ayudthbk"
        //                     ],
        //                     "name" => "JULALAK KUMPI",
        //                     "account" => "XXX-1-62865-X"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => null,
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "0918853402"
        //                 ],
        //                 "ref1" => "4191081549",
        //                 "ref2" => "TITIPAT SRISU",
        //                 "ref3" => "นางสาว ฐิติภัทร ศรีส"
        //             ]
        //         ]
        //     ], [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "202212294u5ezV3DBNBeVD1wX",
        //                 "date" => "2022-12-29T09:28:00+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 09:28",
        //                 "amount" => 530,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว พิชญา สุวรรณศิลป์",
        //                     "account" => "xxxx-xx210-5"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "xxxx-xx154-9"
        //                 ],
        //                 "ref1" => null,
        //                 "ref2" => null,
        //                 "ref3" => null
        //             ]
        //         ]
        //     ], [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "236313167750I000002B9790",
        //                 "date" => "2022-12-29T13:01:13+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 13:01",
        //                 "amount" => 230,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "030",
        //                         "name" => "ธนาคารออมสิน",
        //                         "short" => "gsb",
        //                         "swiftCode" => "gsbathbk"
        //                     ],
        //                     "name" => null,
        //                     "account" => "0201xxxx9743"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "09xxxx3402"
        //                 ],
        //                 "ref1" => "<nil>",
        //                 "ref2" => "<nil>",
        //                 "ref3" => "<nil>"
        //             ]
        //         ]
        //     ],
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "2022122989521826",
        //                 "date" => "2022-12-29T12:59:29+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 12:59",
        //                 "amount" => 450,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "006",
        //                         "name" => "ธนาคารกรุงไทย",
        //                         "short" => "ktb",
        //                         "swiftCode" => "krththbk"
        //                     ],
        //                     "name" => "AREE NONTHICHUN",
        //                     "account" => "XXX-X-XX971-0"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "XXXXXX3402"
        //                 ],
        //                 "ref1" => "<nil>",
        //                 "ref2" => "<nil>",
        //                 "ref3" => "<nil>"
        //             ]
        //         ]
        //     ],
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "202212291101008134",
        //                 "date" => "2022-12-29T11:19:00+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 11:19",
        //                 "amount" => 480,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "011",
        //                         "name" => "ธนาคารทหารไทยธนชาต",
        //                         "short" => "ttb",
        //                         "swiftCode" => "tmbkthbk"
        //                     ],
        //                     "name" => "นาย ชนินทร์ ผูกศิริ",
        //                     "account" => "xxx-x-04588-x"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "4191081549"
        //                 ],
        //                 "ref1" => "",
        //                 "ref2" => "",
        //                 "ref3" => ""
        //             ]
        //         ]
        //     ],
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "012363085932BPP03256",
        //                 "date" => "2022-12-29T08:59:32+07:00",
        //                 "date_human" => "29 ธ.ค. 2022, 08:59",
        //                 "amount" => 480,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "004",
        //                         "name" => "ธนาคารกสิกรไทย",
        //                         "short" => "kbank",
        //                         "swiftCode" => "kasithbk"
        //                     ],
        //                     "name" => "MS. KANYANAT T",
        //                     "account" => "xxx-x-x2515-x"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "xxx-xxx-3402"
        //                 ],
        //                 "ref1" => "<nil>",
        //                 "ref2" => "<nil>",
        //                 "ref3" => "<nil>"
        //             ]
        //         ]
        //     ],
        //     [
        //         "status" => 200,
        //         "message" => [
        //             "data" => [
        //                 "type" => 1,
        //                 "transRef" => "2022122815523223004759308",
        //                 "date" => "2022-12-28T15:52:00+07:00",
        //                 "date_human" => "28 ธ.ค. 2022, 15:52",
        //                 "amount" => 1050,
        //                 "sender" => [
        //                     "bank" => [
        //                         "id" => "002",
        //                         "name" => "ธนาคารกรุงเทพ",
        //                         "short" => "bbl",
        //                         "swiftCode" => "bkkbthbk"
        //                     ],
        //                     "name" => null,
        //                     "account" => "973-0-xxx218"
        //                 ],
        //                 "receiver" => [
        //                     "bank" => [
        //                         "id" => "014",
        //                         "name" => "ธนาคารไทยพาณิชย์",
        //                         "short" => "scb",
        //                         "swiftCode" => "sicothbk"
        //                     ],
        //                     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //                     "account" => "091-xxx-3402"
        //                 ],
        //                 "ref1" => "",
        //                 "ref2" => "",
        //                 "ref3" => null
        //             ]
        //         ]
        //     ]
        // ];


        // foreach ($slips as $key => $slip) {
        //     // ตรวจสอบสถานะ = 200
        //     if ($slip["status"] != "200") {
        //         return "สถานไม่ถูกต้อง";
        //     }

        //     // ตรวจสอบเป็นพร้อมเพย์หรือไม่
        //     $transRef = $slip["message"]["data"]["transRef"];
        //     $date = \Carbon\Carbon::parse($slip["message"]["data"]["date"])->format("Y-m-d H:i:s");
        //     $amount = $slip["message"]["data"]["amount"];
        //     // $sender = $slip["message"]["data"]["sender"];
        //     $receiver = $slip["message"]["data"]["receiver"];
        //     // $receiver_name = $receiver["name"];
        //     // $receiver_account = $receiver["account"];
        //     // $ref1 = $slip["message"]["data"]["ref1"];
        //     // $ref2 = $slip["message"]["data"]["ref2"];
        //     // $ref3 = $slip["message"]["data"]["ref3"];
        //     similar_text("นางสาว ฐิติภัทร ศรีสุข", $receiver["name"], $percent_name);

        //     if ($percent_name == 100) {
        //         return [
        //             "verify" => true,
        //             "transRef" => $transRef,
        //             "amount" => $amount,
        //             "date" => $date
        //         ];
        //     } else if ($percent_name <= 80) {
        //         Linenotify::send("");
        //         return [
        //             "verify" => false,
        //             "transRef" => $transRef,
        //             "amount" => $amount,
        //             "date" => $date
        //         ];
        //     } else {
        //         Linenotify::send("");
        //         return [
        //             "verify" => false,
        //             "transRef" => $transRef,
        //             "amount" => $amount,
        //             "date" => $date
        //         ];
        //     }


        // echo $receiver_name . "  <======== $name% =========>  NO. " . ($key + 1) . " ========>  " . $sender["bank"]["name"] . "<br><br><br>";


        // return $percent_ref3;
        // เช็คพร้อมเพย์
        // if (is_null($receiver["bank"])) {
        //     // "receiver" => [
        //     //     "bank" => null,
        //     //     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //     //     "account" => "0918853402"
        //     // ],
        //     similar_text("นางสาว ฐิติภัทร ศรีสุข", $receiver["name"], $name);
        //     similar_text("0918853402", $receiver["account"], $account);
        //     similar_text("4191081549", $ref1, $ref1);
        //     similar_text("TITIPAT SRISUK", $ref2, $ref2);
        //     similar_text("นางสาว ฐิติภัทร ศรีสุข", $ref3, $ref3);
        //     $avg = ($name + $account + $ref1 + $ref2 + $ref3) / 5;
        //     echo $avg . "% =========>  NO. " . ($key + 1) . " <br><br>";
        //     // if (
        //     //     $ref1 == 100 &&
        //     //     $ref2 >= 90 &&
        //     //     $ref3 >= 90 &&
        //     //     $name >= 90 &&
        //     //     $account == 100 &&
        //     //     $avg >= 94
        //     //     // $ref1 == "4191081549" &&
        //     //     // str_starts_with($ref2, "TITIPAT SR") &&
        //     //     // str_starts_with($ref3, "นางสาว ฐิติภัทร ศรีสุข") &&
        //     //     // $receiver["name"] == "นางสาว ฐิติภัทร ศรีสุข" &&
        //     //     // $receiver["account"] == "0918853402"
        //     // ) {
        //     //     return [
        //     //         "verify" => true,
        //     //         "transRef" => $transRef,
        //     //         "amount" => $amount,
        //     //         "channel" => "promptpay",
        //     //         "date" => $date
        //     //     ];
        //     // } else {
        //     //     return [
        //     //         "verify" => false,
        //     //         "transRef" => $transRef,
        //     //         "amount" => $amount,
        //     //         "channel" => "promptpay"
        //     //     ];
        //     // }
        // }

        // if (isset($receiver["bank"])) {
        //     // "receiver" => [
        //     //     "bank" => [
        //     //         "id" => "014",
        //     //         "name" => "ธนาคารไทยพาณิชย์",
        //     //         "short" => "scb",
        //     //         "swiftCode" => "sicothbk"
        //     //     ],
        //     //     "name" => "นางสาว ฐิติภัทร ศรีสุข",
        //     //     "account" => "xxxx-xx154-9"
        //     // ],

        //     similar_text("sicothbk", $receiver["bank"]["swiftCode"], $swiftCode);
        //     similar_text("นางสาว ฐิติภัทร ศรีสุข", $receiver["name"], $name);
        //     similar_text("xxxx-xx154-9", $receiver["account"], $account);
        //     $avg = ($swiftCode + $name + $account) / 3;
        //     echo $avg . "% =========>  NO. " . ($key + 1) . " <br><br>";
        //     // if (
        //     //     $swiftCode == 100 &&
        //     //     $name >= 90 &&
        //     //     $account == 100 &&
        //     //     $avg >= 95
        //     //     // $receiver["bank"]["swiftCode"] == "sicothbk" &&
        //     //     // $receiver["name"] == "นางสาว ฐิติภัทร ศรีสุข" &&
        //     //     // $receiver["account"] == "xxxx-xx154-9"

        //     // ) {
        //     //     return [
        //     //         "verify" => true,
        //     //         "transRef" => $transRef,
        //     //         "amount" => $amount,
        //     //         "channel" => "bank_account",
        //     //         "date" => $date
        //     //     ];
        //     // } else {
        //     //     return [
        //     //         "verify" => false,
        //     //         "transRef" => $transRef,
        //     //         "amount" => $amount,
        //     //         "channel" => "bank_account"
        //     //     ];
        //     // }
        // }
        // }
    }

    public function FacebookImagesAlertPaymentJob()
    {
        // $d = FacebookImages::find("7");
        FacebookImagesAlertPaymentJob::dispatch();
        // ->delay(now()->addMinutes(1));
        return;
    }

    public function get_psid_profile(Request $request)
    {
        $psid = $request->get("psid");
        $customer = Facebook::where("psid", $psid)->with("customer")->first();
        return $customer;
    }

    public function post_psid_profile()
    {
    }
}
