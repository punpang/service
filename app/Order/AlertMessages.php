<?php

namespace App\Order;

use Bitly;
use App\URL;
use App\MSms;
use App\Linenotify;
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
        $bitly = AOrder::genlinkUuid($order->id);
        $nbfm_amount = number_format($amount, 2);
        $msgSms = 'ขอบคุณที่ชำระเงิน จำนวน ' . $nbfm_amount  . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' รายละเอียดรายการสั่งซื้อคลิกลิงก์ [ ' . $bitly . ' ]\n\nวัน-เวลานัดรับสินค้า\n' . $order->dateGetTimeFormat();
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);

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
        $bitly = AOrder::genlinkUuid($order->id);
        $nbfm_amount = number_format($amount, 2);
        $msgSms = 'รายการแจ้งชำระเงินของคุณ ไม่ผ่านการตรวจสอบ จำนวน ' . $nbfm_amount  . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' หากไม่ถูกต้อง "โปรดแนบสลิปใหม่" เพื่อตรวจสอบอีกครั้ง คลิกลิงก์ [ ' . $bitly . ' ]\n\nหรือติดต่อทางร้าน 091-885-3402 เพื่อขออุทธรณ์';
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
        $bitly = AOrder::genlinkUuid($order->id);
        $nbfm_amountNew = number_format($amountNew, 2);
        $nbfm_amountOld = number_format($amountOld, 2);
        $msgSms = 'ปรับยอดชำระเงินจาก ยอดเก่า ' . $nbfm_amountOld  . ' บาท เป็นยอดใหม่ ' . $nbfm_amountNew . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' รายละเอียดคลิกลิงก์ [ ' . $bitly . ' ]\n\nรายละเอียดเพิ่มเติม โปรดติดต่อทางร้าน 091-885-3402 ต้องขออภัยในความผิดพลาดค่ะ';
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
        $bitly = AOrder::genlinkUuid($order->id);
        $msgSms = 'คุณขออุทธร์รายการชำระเงิน เราจะตรวจสอบรายการให้อีกครั้ง หมายเลขคำสั่งซื้อ #' . $order->id . ' รายละเอียดคลิกลิงก์ [ ' . $bitly . ' ]\n\nต้องขออภัยในความผิดพลาดค่ะ';
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

        $msgSms = 'คุณได้รับ ' . $amount . ' คะแนน และมีทั้งหมด ' . $sumDiffScore . ' คะแนน';
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

    public static function smsAlertPayment($order, $bitly, $alertSMS = true)
    {
        $msgSms = 'แจ้งชำระเงิน สำหรับหมายเลขคำสั่งซื้อ #' . $order->id . " สามารถชำระเงินภายในลิงก์ [ " . $bitly . " ] โปรดชำระก่อน " . $order->payment_deadline . " เพื่อยืนยันรายการสั่งซื้อของท่าน";
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function bothNoticeOfPaymentByCustomer($orderID, $amount, $alertSMS = true)
    {
        $order = AOrder::findOrFail($orderID);
        $nbfm_amount = number_format($amount, 2);
        $msgLine = 'แจ้งชำระเงินจากลูกค้า -> #' . $order->id . ' จำนวน ' . $nbfm_amount . ' บาท ';

        $link = URL::base() . "/o/" . $order->auth_order;
        $bitly = Bitly::getUrl($link);
        $msgSms = 'เราได้รับการแจ้งชำระเงินของคุณ จำนวน ' . $nbfm_amount  . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' เราจะตรวจสอบและยืนยันการชำระเงิน ภายใน 15 นาที หลังจากชำระเงิน รายละเอียดรายการสั่งซื้อคลิกลิงก์ [ ' . $bitly . ' ]\n\nวัน-เวลานัดรับสินค้า\n' . $order->dateGetTimeFormat();
        Linenotify::send($msgLine);
        MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function smsImageGoodsReviewToCustomer($order, $alertSMS = true)
    {
        $bitly = AOrder::genlinkUuid($order->id);
        $msgSms = "รูปภาพสินค้าของท่าน [ " . $bitly . " ]";
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }

    public static function lineChangeDateTimeGet($order)
    {
        $msgLine = 'เปลี่ยนแปลงวัน-เวลารับ => #' . $order->id . " | " . $order->date_get . " " . $order->time_get;
        return Linenotify::send($msgLine);
    }

    public static function smsChangeDateTimeGet($order, $alertSMS = true)
    {
        $link = URL::base() . "/o/" . $order->auth_order;
        $bitly = Bitly::getUrl($link);

        $msgSms = 'หมายเลขคำสั่งซื้อ #' . $order->id . " ของคุณ ได้เปลี่ยนแปลงวัน-เวลานัดรับเป็น " . $order->date_get . " " . $order->time_get . " น. รายละเอียดคำสั่งซื้อคลิกลิงก์ [ " . $bitly . " ]";
        return MSms::Sms($order->customer->tel, $msgSms, $alertSMS);
    }
}
