<?php

namespace App\Http\Controllers\Momday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Linenotify;
use App\Momday\Order;
use App\Momday\payment;
use App\MSms;

class paymentController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::where("id", $request->order['id'])->first();

        $overDateEnd = Order::overDateEnd($order->promotion->date_end, $order->order_status_id);
        if ($overDateEnd) {
            return response()->json(
                [
                    "msgTitle" => "ไม่สามารถชำระเงิน",
                    "msgText" => "เนื่องจากเลยกำหนดเวลาชำระเงินของโปรโมชั่น หากท่านชำระเงินไปแล้ว โทร. 091-885-3402"
                ],
                201
            );
        }

        if ($order->order_status_id != 1) {
            return response()->json(
                [
                    "msgTitle" => "โปรดอ่านรายละเอียด",
                    "msgText" => "ไม่สามารถชำระเงินได้ เนื่องจากไม่ได้อยู่ในสถานะ : สร้างรายการสั่งซื้อแล้ว"
                ],
                201
            );
        }

        $payment = payment::where("order_id", $request->order['id'])
            ->where("status_use", 1)
            ->first();

        if ($payment) {
            return response()->json(
                [
                    "msgTitle" => "แจ้งชำระเงินแล้ว",
                    "msgText" => "ทำรายการไปก่อนหน้านี้แล้ว"
                ],
                201
            );
        }

        $payment = new payment;
        $payment->order_id = $request->order['id'];
        $payment->sum_price = $request->order['sum_price_special'];
        $payment->image_slip = $request->image_slip;
        $payment->save();

        $order->order_status_id = 2;
        $order->time_get = Order::queue($request->order["promotion_id"]);
        $order->save();

        $msgSms = "ขอบคุณที่ชำระเงินค่ะ ทางร้านจะดำเนินการตรวจสอบและแจ้งผลโดยเร็วที่สุดค่ะ คุณอาจได้รับคิว " . $order->time_get . " น. เป็นต้นไป ";

        MSms::Sms($order->customer->phone_number, $msgSms);
        Linenotify::send("ลูกค้าแจ้งชำระเงิน");

        return response()->json(
            [
                "msgTitle" => "ชำระเงินสำเร็จ",
                "msgText" => $msgSms
            ],
            200
        );
    }

    public function storeCash(Request $request)
    {
        $order = Order::where("id", $request->order['id'])->first();

        $overDateEnd = Order::overDateEnd($order->promotion->date_end, $order->order_status_id);
        if ($overDateEnd) {
            return response()->json(
                [
                    "msgTitle" => "ไม่สามารถชำระเงิน",
                    "msgText" => "เนื่องจากเลยกำหนดเวลาชำระเงินของโปรโมชั่น หากท่านชำระเงินไปแล้ว โทร. 091-885-3402"
                ],
                201
            );
        }

        if ($order->order_status_id != 1) {
            return response()->json(
                [
                    "msgTitle" => "โปรดอ่านรายละเอียด",
                    "msgText" => "ไม่สามารถชำระเงินได้ เนื่องจากไม่ได้อยู่ในสถานะ : สร้างรายการสั่งซื้อแล้ว"
                ],
                201
            );
        }

        $payment = payment::where("order_id", $request->order['id'])
            ->where("status_use", 1)
            ->first();

        if ($payment) {
            return response()->json(
                [
                    "msgTitle" => "ชำระเงินแล้ว",
                    "msgText" => "ทำรายการไปก่อนหน้านี้แล้ว"
                ],
                201
            );
        }

        $payment = new payment;
        $payment->order_id = $request->order['id'];
        $payment->payment_method_id = 2;
        $payment->sum_price = $order->sum_price_special;
        $payment->payment_amount = $request->payment['payment_amount'];
        $payment->change = $request->payment['change'];
        $payment->status_payment = 2;
        $payment->save();

        $order->order_status_id = 3;
        $order->time_get = Order::queue($order->promotion->id);
        $order->save();

        $msgSms = "เราตรวจสอบการชำระเงินเรียบร้อย คิวรับสินค้าของท่าน คือ " .
            $order->promotion->date_get . " " . $order->time_get . " น. สามารถรับสินค้าได้ตั้งแต่เวลาที่เราแจ้งจนถึง 19.00 น. รายละเอียดคลิกลิงก์ [ " . $order->url . " ]";

        MSms::Sms($order->customer->phone_number, $msgSms);

        return response()->json(
            [
                "msgTitle" => "เสร็จสิ้น",
                "msgText" => "คิวรับสินค้า " . $order->promotion->date_get . " " . $order->time_get . " น."
            ],
            200
        );
    }

    public function fetchCheck()
    {
        $data = payment::where("status_use", 1)
            ->where("status_payment", 1)
            ->first();

        return response()->json($data, 200);
    }

    public function fetchByOrderId($order_id)
    {
        $payment = payment::where("order_id", $order_id)
            ->where("status_use", 1)
            ->where("status_payment", 1)
            ->first();

        return response()->json($payment, 200);
    }

    public function confirm(payment $payment, Request $request)
    {
        // dd($request);
        if ($payment->status_payment != 1) {
            return response()->json(
                [
                    "msgTitle" => "ยืนยันการชำระไปแล้ว"
                ],
                201
            );
        }

        if ($payment->status_use == 0) {
            return response()->json(
                [
                    "msgTitle" => "ยกเลิกรายการไปแล้ว"
                ],
                201
            );
        }

        $order = Order::where("id", $payment->order_id)->first();

        if ($order->order_status_id != 2) {
            return response()->json(
                [
                    "msgTitle" => "ไม่ได้อยู่สถานะการแจ้งชำระเงิน"
                ],
                201
            );
        }

        if ($order->status_use == 0) {
            return response()->json(
                [
                    "msgTitle" => "รายการถูกยกเลิกไปแล้ว"
                ],
                201
            );
        }

        $checkRef = payment::where("ref1", $request->ref1)->where("status_use", 1)->first();

        if ($checkRef) {
            return response()->json([
                "msgTitle" => "อ้างอิงซ้ำ"
            ], 201);
        }

        $payment->status_payment = 2;
        $payment->payment_amount = $payment->sum_price;
        $payment->ref1 = $request->ref1;
        $payment->save();

        $order->order_status_id = 3;
        $order->time_get = Order::queue($order->promotion_id);
        $order->save();

        $msgSms = "เราตรวจสอบการชำระเงินเรียบร้อย คิวรับสินค้าของท่าน คือ " .
            $order->promotion->date_get . " " . $order->time_get . " น. สามารถรับสินค้าได้ตั้งแต่เวลาที่เราแจ้งจนถึง 19.00 น. รายละเอียดคลิกลิงก์ [ " . $order->url . " ]";

        MSms::Sms($order->customer->phone_number, $msgSms);

        return response()->json(
            ["msgTitle" => "เสร็จสิ้น"],
            200
        );
    }

    public function confirmOnline(payment $payment, Request $request)
    {
        // dd($request->payment_amount, $payment->sum_price);
        if ($payment->sum_price != $request->payment_amount) {
            return response()->json(
                [
                    "msgTitle" => "ยอดเงินไม่ถูกต้อง"
                ],
                201
            );
        }

        if ($payment->status_payment != 1) {
        }

        if ($payment->status_use == 0) {
            return response()->json(
                [
                    "msgTitle" => "ยกเลิกรายการไปแล้ว"
                ],
                201
            );
        }

        $order = Order::where("id", $payment->order_id)->first();

        if ($order->order_status_id != 2) {
            return response()->json(
                [
                    "msgTitle" => "ไม่ได้อยู่สถานะการแจ้งชำระเงิน"
                ],
                201
            );
        }

        if ($order->status_use == 0) {
            return response()->json(
                [
                    "msgTitle" => "รายการถูกยกเลิกไปแล้ว"
                ],
                201
            );
        }

        $checkRef = payment::whereIn("ref1", [$request->ref1, $request->ref2])
            ->whereIn("ref2", [$request->ref1, $request->ref2])
            ->where("status_use", 1)
            ->first();

        if ($checkRef) {
            return response()->json([
                "msgTitle" => "อ้างอิงซ้ำ"
            ], 201);
        }

        $payment->status_payment = 2;
        $payment->payment_amount = $request->payment_amount;
        $payment->ref1 = $request->ref1;
        $payment->ref2 = $request->ref2;
        $payment->save();

        $order->order_status_id = 3;
        $order->time_get = Order::queue($order->promotion_id);
        $order->save();

        $msgSms = "เราตรวจสอบการชำระเงินเรียบร้อย คิวรับสินค้าของท่าน คือ " .
            $order->promotion->date_get . " " . $order->time_get . " น. สามารถรับสินค้าได้ตั้งแต่เวลาที่เราแจ้งจนถึง 19.00 น. รายละเอียดคลิกลิงก์ [ " . $order->url . " ]";

        MSms::Sms($order->customer->phone_number, $msgSms);

        return response()->json(
            ["msgTitle" => "เสร็จสิ้น"],
            200
        );
    }

    public function cancel(payment $payment, Request $request)
    {
        // dd($request);
        if ($payment->status_payment != 1) {
            return response()->json(
                [
                    "msgTitle" => "ยืนยันการชำระไปแล้ว"
                ],
                201
            );
        }

        if ($payment->status_use == 0) {
            return response()->json(
                [
                    "msgTitle" => "ยกเลิกรายการไปแล้ว"
                ],
                201
            );
        }

        $order = Order::where("id", $payment->order_id)->first();

        if ($order->order_status_id != 2) {
            return response()->json(
                [
                    "msgTitle" => "ไม่ได้อยู่สถานะการแจ้งชำระเงิน"
                ],
                201
            );
        }

        if ($order->status_use == 0) {
            return response()->json(
                [
                    "msgTitle" => "รายการถูกยกเลิกไปแล้ว"
                ],
                201
            );
        }

        $payment->status_payment = 3;
        $payment->status_use = 0;
        $payment->ref2 = $request->ref2;
        $payment->save();

        $order->order_status_id = 1;
        $order->time_get = Order::queue($order->promotion_id);
        $order->save();

        $msgSms = "เราตรวจสอบการชำระเงินเรียบร้อย ชำระเงินไม่ผ่าน มีสาเหตุมาจาก " . $payment->ref2 . " โปรดแจ้งชำระเงินใหม่ คลิกลิงก์ [ " . $order->url . " ]";

        MSms::Sms($order->customer->phone_number, $msgSms);

        return response()->json(
            ["msgTitle" => "เสร็จสิ้น"],
            200
        );
    }
}
