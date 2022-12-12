<?php

namespace App\Order;

// use Bitly;
// use App\URL;
use App\MSms;
use App\Linenotify;
use App\Order\Line;
use App\Order\AOrder;
use Illuminate\Database\Eloquent\Model;

class AlertMessages extends Model
{

    public static function lineError($message)
    {
        return Linenotify::send($message);
    }

    public static function lineAlertGeneral($message)
    {
        return Linenotify::send($message);
    }

    public static function linePaymentOrder($order, $amount)
    {
        $nbfm_amount = number_format($amount, 2);
        $msgLine = 'รับชำระเงิน -> #' . $order->id . ' จำนวน ' . $nbfm_amount . ' บาท ';
        return Linenotify::send($msgLine);
    }

    public static function smsPaymentOrder($order_id, $amount, $alertSMS = true)
    {
        $order = AOrder::findOrFail($order_id);
        // $link = URL::base() . "/o/" . $order->auth_order;
        // $bitly = Bitly::getUrl($link);
        // $bitly = AOrder::genlinkUuid($order->id);
        $nbfm_amount = number_format($amount, 2);
        $msgSms = 'ขอบคุณที่ชำระเงิน จำนวน ' . $nbfm_amount  . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' รายละเอียดรายการสั่งซื้อคลิกลิงก์ [ ' . $order->link_for_customer . ' ]\n\nวัน-เวลานัดรับสินค้า\n' . $order->dateGetTimeFormat();

        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);

        //AHistoryPayed
        //
    }

    public static function socialPaymentOrder($order, $amount, $is_pickup = false)
    {
        if ($is_pickup != true) {
            $nbfm_amount = number_format($amount, 2);

            Line::flex_receipt($order);
            $msgFacebook = "- เวลานัดรับข้างต้น เป็นเพียงเวลาที่สินค้าจะจัดเตรียมเสร็จ
- ลูกค้าสามารถรับสินค้าได้ตั้งแต่เวลานัดรับ หรือหลังจากได้รับ SMS แจ้งเตือนให้สามารถเข้ารับสินค้าได้แล้ว
- ไม่สามารถรับสินค้าก่อนเวลานัดรับได้
- หากต้องการเปลี่ยนแปลงเวลานัดรับ โปรดแจ้งล่วงหน้าอย่างน้อย 3 ชั่วโมง ของเวลานัดรับใหม่
- โปรดรับสินค้าก่อนร้านปิด (19:00 น.) เนื่องจากไม่สามารถติดต่อและรับสินค้าหลังเวลาร้านปิดได้ ขออภัยในความไม่สะดวก
********
*สินค้าทุกรายการจำเป็นต้องแช่เย็น เพื่อรักษาคุณภาพสูงสุด*";

            Facebook::send_reply_message(
                $order,
                $msgFacebook
            );

            Facebook::send_postback(
                $order,
                [
                    [
                        "title" => "ขอบคุณที่ชำระเงิน #$order->id",
                        "subtitle" => "จำนวน $nbfm_amount บาท",
                        "buttons" => [
                            [
                                "title" => "รายละเอียดเพิ่มเติม",
                                "url" => $order->link_for_customer,
                                "type" => "web_url"
                            ]
                        ]
                    ]
                ]
            );
        }
        //AHistoryPayed
        //
    }

    public static function linePaymentOrderCancel($order, $amount)
    {
        $nbfm_amount = number_format($amount, 2);
        $msgLine = 'ยกเลิกรายการชำระเงิน -> #' . $order->id . ' จำนวน ' . $nbfm_amount . ' บาท | รายการซ้ำ';
        return Linenotify::send($msgLine);

        //NoticeOfPaymentFromCustomerController
    }

    public static function smsPaymentOrderCancel($order_id, $amount, $alertSMS = true)
    {
        $order = AOrder::findOrFail($order_id);
        // $link = URL::base() . "/o/" . $order->auth_order;
        // $bitly = Bitly::getUrl($link);
        // $bitly = AOrder::genlinkUuid($order->id);
        $nbfm_amount = number_format($amount, 2);
        $msgSms = 'รายการแจ้งชำระเงินของคุณ ไม่ผ่านการตรวจสอบ จำนวน ' . $nbfm_amount  . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' หากไม่ถูกต้อง "โปรดแนบสลิปใหม่" เพื่อตรวจสอบอีกครั้ง คลิกลิงก์ [ ' . $order->link_for_customer . ' ]\n\nหรือติดต่อทางร้าน 091-885-3402 เพื่อขออุทธรณ์';
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);

        //NoticeOfPaymentFromCustomerController
    }

    public static function linePaymentOrderUpdate($order, $amountNew, $amountOld)
    {
        $nbfm_amountNew = number_format($amountNew, 2);
        $nbfm_amountOld = number_format($amountOld, 2);
        $msgLine = 'ปรับยอดชำระเงิน -> #' . $order->id . ' จาก ' . $nbfm_amountOld . ' บาท เป็น ' . $nbfm_amountNew . ' บาท';
        return Linenotify::send($msgLine);
    }

    public static function smsPaymentOrderUpdate($order_id, $amountNew, $amountOld, $alertSMS = true)
    {
        $order = AOrder::findOrFail($order_id);
        // $bitly = AOrder::genlinkUuid($order->id);
        $nbfm_amountNew = number_format($amountNew, 2);
        $nbfm_amountOld = number_format($amountOld, 2);
        $msgSms = 'ปรับยอดชำระเงินจาก ยอดเก่า ' . $nbfm_amountOld  . ' บาท เป็นยอดใหม่ ' . $nbfm_amountNew . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' รายละเอียดคลิกลิงก์ [ ' . $order->link_for_customer . ' ]\n\nรายละเอียดเพิ่มเติม โปรดติดต่อทางร้าน 091-885-3402 ต้องขออภัยในความผิดพลาดค่ะ';
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function linePaymentOrderAppeal($order)
    {
        $msgLine = 'ยื่นอุทธรณ์ -> #' . $order->id;
        return Linenotify::send($msgLine);
    }

    public static function smsPaymentOrderAppeal($order_id, $alertSMS = true)
    {
        $order = AOrder::findOrFail($order_id);
        // $bitly = AOrder::genlinkUuid($order->id);
        $msgSms = 'คุณขออุทธร์รายการชำระเงิน เราจะตรวจสอบรายการให้อีกครั้ง หมายเลขคำสั่งซื้อ #' . $order->id . ' รายละเอียดคลิกลิงก์ [ ' . $order->link_for_customer . ' ]\n\nต้องขออภัยในความผิดพลาดค่ะ';
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function lineAddScore($customer, $amount)
    {
        $msgLine = 'เพิ่มแต้ม -> #' . $customer->id . " | " . $amount . " คะแนน";
        return Linenotify::send($msgLine);
    }

    public static function smsAddScore($customer, $amount, $alertSMS = true)
    {
        if (!empty($customer->sumDiffScore())) {
            $sumDiffScore = $customer->sumDiffScore();
        } else {
            $sumDiffScore = 0;
        }

        $msgSms = 'คุณได้รับ ' . $amount . ' คะแนน และมีทั้งหมด ' . number_format($sumDiffScore, 0) . ' คะแนน';
        return MSms::Sms($customer->tel, $msgSms, $alertSMS);
    }

    public static function lineAdjustExcessPayment($customer, $amount, $option)
    {
        $msgLine = 'คืนยอดเงินส่วนเกิน -> #' . $customer->id . " | " . number_format($amount, 2) . " บาท เป็น" . $option["text"];
        return Linenotify::send($msgLine);
    }

    public static function smsAdjustExcessPayment($customer, $amount, $option, $alertSMS = true)
    {
        $msgSms = "คืนยอดเงินส่วนเกิน " . number_format($amount, 2) . " บาท เป็น" . $option["text"] . " ให้ท่านแล้ว";
        return MSms::Sms($customer->tel, $msgSms, $alertSMS);
    }

    public static function lineUseScore($customer, $amount)
    {
        $msgLine = 'ลดแต้ม -> #' . $customer->id . " | " . $amount . " คะแนน";
        return Linenotify::send($msgLine);
    }

    public static function smsUseScore($customer, $amount, $alertSMS = true)
    {
        if (!empty($customer->sumDiffScore())) {
            $sumDiffScore = $customer->sumDiffScore();
        } else {
            $sumDiffScore = 0;
        }

        $msgSms = 'คุณใช้ ' . $amount . ' คะแนน และคงเหลือ ' . $sumDiffScore . ' คะแนน';
        return MSms::Sms($customer->tel, $msgSms, $alertSMS);
    }

    public static function lineAlertPayment($order)
    {
        $msgLine = 'แจ้งชำระเงิน -> #' . $order->id;
        return Linenotify::send($msgLine);
    }

    public static function smsAlertPayment($order, $alertSMS = true)
    {
        $msgSms = 'แจ้งชำระเงิน สำหรับหมายเลขคำสั่งซื้อ #' . $order->id . " สามารถชำระเงินภายในลิงก์ [ " . $order->link_for_customer . " ] โปรดชำระก่อน " . $order->payment_deadline_th . " เพื่อยืนยันรายการสั่งซื้อของท่าน";
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function bothNoticeOfPaymentByCustomer($orderID, $amount, $alertSMS = true)
    {
        $order = AOrder::findOrFail($orderID);
        $nbfm_amount = number_format($amount, 2);
        $msgSms = 'เราได้รับการแจ้งชำระเงินของคุณ จำนวน ' . $nbfm_amount  . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' เราจะตรวจสอบและยืนยันการชำระเงิน ภายใน 15 นาที หลังจากชำระเงิน รายละเอียดรายการสั่งซื้อคลิกลิงก์ [ ' . $order->link_for_customer . ' ]\n\nวัน-เวลานัดรับสินค้า\n' . $order->dateGetTimeFormat();
        MSms::Sms($order->customer->tel, $msgSms, $alertSMS);

        $msgLine = 'แจ้งชำระเงินจากลูกค้า -> #' . $order->id . ' จำนวน ' . $nbfm_amount . ' บาท ';
        Linenotify::send($msgLine);
    }

    public static function socialNoticeOfPaymentByCustomer($order, $amount)
    {
        $nbfm_amount = number_format($amount, 2);
        $msg = 'เราได้รับการแจ้งชำระเงินของคุณ จำนวน ' . $nbfm_amount  . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' เราจะตรวจสอบและยืนยันการชำระเงิน ภายใน 15 นาที หลังจากชำระเงิน';
        Facebook::send_reply_message($order, $msg);
        Facebook::send_postback(
            $order,
            [
                [
                    "title" => "ตรวจสอบรายการสั่งซื้อ",
                    "buttons" => [
                        [
                            "title" => "รายละเอียดเพิ่มเติม",
                            "url" => $order->link_for_customer,
                            "type" => "web_url"
                        ]
                    ]
                ]
            ]
        );
        Line::send($order, $msg);
    }

    public static function smsImageGoodsReviewToCustomer($order, $alertSMS = true)
    {
        // $bitly = AOrder::genlinkUuid($order->id);
        $msgSms = "รูปภาพสินค้าของท่าน [ " . $order->link_for_customer . " ]";
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function socialImageGoodsReviewToCustomer($detail, $status_send = true)
    {
        foreach ($detail->imageGoodsReviewToCustomers as $image) {
            Facebook::send_reply_image($detail->aOrder, "https://lh3.googleusercontent.com/d/" . $image->googleImage->src_name, $status_send);
        }
    }

    public static function lineChangeDateTimeGet($order)
    {
        $msgLine = 'เปลี่ยนแปลงวัน-เวลารับ => #' . $order->id . " | " . $order->date_get . " " . $order->time_get;
        return Linenotify::send($msgLine);
    }

    public static function smsChangeDateTimeGet($order, $alertSMS = true)
    {
        // $link = URL::base() . "/o/" . $order->auth_order;
        // $bitly = Bitly::getUrl($link);

        $msgSms = 'หมายเลขคำสั่งซื้อ #' . $order->id . " ของคุณ ได้เปลี่ยนแปลงวัน-เวลานัดรับเป็น " . $order->date_get_th . " " . $order->time_get . " น. รายละเอียดคำสั่งซื้อคลิกลิงก์ [ " . $order->link_for_customer . " ]";

        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function socialChangeDateTimeGet($order, $status_send = true)
    {
        // $link = URL::base() . "/o/" . $order->auth_order;
        // $bitly = Bitly::getUrl($link);

        $msg = 'หมายเลขคำสั่งซื้อ #' . $order->id . " ของคุณ ได้เปลี่ยนแปลงวัน-เวลานัดรับเป็น " . $order->date_get_th . " " . $order->time_get . " น. ";
        Facebook::send_reply_message($order, $msg, $status_send);
        Facebook::send_postback(
            $order,
            [
                [
                    "title" => "ตรวจสอบรายละเอียด",
                    "buttons" => [
                        [
                            "title" => "รายการสั่งซื้อ",
                            "url" => $order->link_for_customer,
                            "type" => "web_url"
                        ]
                    ]
                ]
            ],
            $status_send
        );
        Line::send($order, $msg);
    }

    public static function linePrepareGoods($order)
    {
        $msgLine = 'จัดเตรียมสินค้า => #' . $order->id;
        return Linenotify::send($msgLine);
    }

    public static function smsPrepareGoods($order, $alertSMS = true)
    {
        if ($order->orderDeliveryService) {
            $msgSms = 'หมายเลขคำสั่งซื้อ #' . $order->id . " ของคุณ สินค้าจัดเตรียมเรียบร้อยแล้ว อยู่ระหว่างการจัดส่ง เราจะแจ้งคุณอีกครั้งเมื่อจัดส่ง รายละเอียดคำสั่งซื้อคลิกลิงก์ [ " . $order->link_for_customer . " ]";
        } else {
            $msgSms = 'หมายเลขคำสั่งซื้อ #' . $order->id . " ของคุณ สินค้าจัดเตรียมเรียบร้อยแล้ว สามารถเข้ารับสินค้าได้ทันที *ไม่สามารถรับสินค้าหลังเวลาร้านปิดได้ รายละเอียดคำสั่งซื้อคลิกลิงก์ [ " . $order->link_for_customer . " ]";
        }
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function linePickUpGoods($order)
    {
        $msgLine = 'รับสินค้าเรียบร้อย => #' . $order->id;
        return Linenotify::send($msgLine);
    }

    public static function smsPickUpGoods($order, $alertSMS = true)
    {
        $msgSms = 'คุณได้รับสินค้าหมายเลขคำสั่งซื้อ #' . $order->id . " ของคุณเรียบร้อย ขอบคุณที่ให้ความไว้วางใจกับทางร้าน ทางร้านขอนำภาพสินค้าของท่านใช้งานประชาสัมพันธ์ของทางร้าน หากไม่ยินยอมสามารถแจ้งได้ทุกเมื่อ ให้คะแนนคำสั่งซื้อนี้ได้ที่ [ " . $order->link_for_customer . " ]";
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function lineShippingGoods($order)
    {
        $msgLine = 'กำลังจัดส่งสินค้า => #' . $order->id;
        return Linenotify::send($msgLine);
    }

    public static function smsShippingGoods($order, $alertSMS = true)
    {
        if ($order->orderDeliveryService->rider_name) {
            $rider_name = "ชื่อไรเดอร์ " . $order->orderDeliveryService->rider_name . " ";
        } else {
            $rider_name = "";
        }

        if ($order->orderDeliveryService->rider_phone) {
            $rider_phone = "(" . $order->orderDeliveryService->rider_phone . ") ";
        } else {
            $rider_phone = "";
        }

        if ($order->orderDeliveryService->delivery_platform) {
            $delivery_platform = "จัดส่งโดย " . $order->orderDeliveryService->delivery_platform . " ";
        } else {
            $delivery_platform = "";
        }

        if ($order->orderDeliveryService->rider_link) {
            $rider_link = "[ " . $order->orderDeliveryService->rider_link . " ] ";
        } else {
            $rider_link = "";
        }

        $msgSms = 'หมายเลขคำสั่งซื้อ #' . $order->id . " ของคุณ ขณะนี้กำลังจัดส่ง " . $delivery_platform . $rider_name . $rider_phone . $rider_link . " รายละเอียดคำสั่งซื้อคลิกลิงก์ [ " . $order->link_for_customer . " ]";
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function lineDeliverySuccessGoods($order)
    {
        $msgLine = 'จัดส่งสินค้าเรียบร้อย => #' . $order->id;
        return Linenotify::send($msgLine);
    }

    public static function smsDeliverySuccessGoods($order, $alertSMS = true)
    {
        $msgSms = 'หมายเลขคำสั่งซื้อ #' . $order->id . " ของคุณ จัดส่งเรียบร้อยแล้ว";
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function lineCustomerNoPayment($order)
    {
        $msgLine = 'ไม่สะดวกชำระเงิน => #' . $order->id;
        return Linenotify::send($msgLine);
    }

    public static function smsCustomerNoPayment($order, $waiting_period, $alertSMS = true)
    {
        $msgSms = "ทางร้านขอนัดลูกค้าเข้าร้าน " . $order->date_get_th . " " . $order->time_get . " น. เพื่อรอจัดเตรียมสินค้า " . $waiting_period . "

*หากลูกค้าเข้าร้านก่อนหรือหลังเวลาที่นัด อาจใช้เวลาการเตรียมมากว่าปกติ";
        Line::flex_customer_noPayment($order, $waiting_period);
        Facebook::send_reply_message($order, $msgSms);
        Facebook::send_postback(
            $order,
            [
                [
                    "title" => "รายละเอียดสินค้าและชำระเงิน",
                    "buttons" => [
                        [
                            "title" => "กดที่นี่",
                            "url" => $order->link_for_customer,
                            "type" => "web_url"
                        ]
                    ]
                ]
            ]
        );

        return MSms::Sms($order->customer->tel, $msgSms . " รายละเอียดคำสั่งซื้อ คลิกลิงก์ [ " . $order->link_for_customer . " ]", $alertSMS);
    }

    public static function smsConfirmConsentConditions($customer, $alertSMS = true)
    {
        $msgSms = "คุณได้ยอมรับเงื่อนไขการสั่งซื้อแล้ว คุณสามารถศึกษาเงื่อนไขได้ที่ [ https://punpang.net/learning/conditions/order ]";
        return MSms::Sms($customer->tel, $msgSms, $alertSMS);
    }
}
