<?php

namespace App\Http\Controllers\Order;

use App\URL;
use App\Linenotify;
use Zxing\QrReader;
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
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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
            if ($FacebookWebhook->reply && !$is_time_close_store) {
                Facebook::reply_message_v2($sender, $FacebookWebhook->reply->text_th);
            }

            // ตอบคะแนนของลูกค้า
            // if ($message == "คะแนนของฉัน") {
            //     Facebook::sumCustomerScore($profile, $sender);
            //     // return $request["hub_challenge"];
            // }
        }

        // มี Image
        if (!empty($input['entry'][0]['messaging'][0]['message']['attachments'])) {
            $attachments = $input['entry'][0]['messaging'][0]['message']['attachments'];
            foreach ($attachments as $attachment) {
                if ($attachment["type"] == "image") {
                    FacebookImages::createImages($attachment, $profile);
                    // $attachment["payload"]["url"];
                }
            }
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

        $datas->orderBy("updated_at", "DESC");

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
        // $path_to_image = "https://scontent.xx.fbcdn.net/v/t1.15752-9/320095387_1290231448216228_8449009203720903444_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=58c789&_nc_ohc=Gr-LfqWvbaUAX847LiN&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdSca0GP0eoshxnOlbZvnx2ghsYr7_D8Fa0Q_Zj3tu9Fqw&oe=63C8E750";
        // $qrcode = new QrReader($path_to_image);
        // $text = $qrcode->text();
        // return $text;
        // file_put_contents("images/qr-code/$unique.png", $data);
        $qr = QrCode::size(300)->format("png")->generate('010156416503413035105416541651065');
        // file_put_contents("images/qr-code/test_qr_code.png", $qr);
        // $path_to_image = $qr;
        // $qrcode = new QrReader($path_to_image);
        // $text = $qrcode->text();
        // return $text;
        // file_put_contents("images/qr-code/$unique.png", $data);
        // Linenotify::send($qr);
        return $qr;
    }
}
