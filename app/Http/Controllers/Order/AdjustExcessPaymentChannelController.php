<?php

namespace App\Http\Controllers\Order;

use App\Order\AOrder;
use App\Order\AlertMessages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\AdjustExcessPaymentChannel;

class AdjustExcessPaymentChannelController extends Controller
{
    public function fetch()
    {
        return response()->json([
            "status" => "success",
            "data" =>  AdjustExcessPaymentChannel::get(),
            // "sweetAlert" => [
            //     "title" => "สำเร็จ",
            //     "text" => "โหลดข้อมูลเสร็จ",
            //     "icon" => "success",
            //     "timer" => 3000,
            //     "timerProgressBar" => true,
            //     "showConfirmButton" => false,
            //     "toast" => true,
            //     "position" => "bottom-end"
            // ]
        ], 200);
    }

    public function store(AOrder $order, Request $request)
    {
        if ($order->sumBalance() >= 0) {
            return response()->json([
                "status" => "error",
                "message" => "ไม่มียอดปรับส่วนเกิน",
                "title" => "โปรดอ่าน",
                "icon" => "warning"
            ], 201);
        }
        $amount = $order->sumBalance() * -1;

        $order->adjustExcessPayments()->create([
            "amount" => $amount,
            "adjust_excess_payment_channel_id" => $request->option["id"]
        ]);

        AlertMessages::lineAdjustExcessPayment($order->customer, $amount, $request->option);
        AlertMessages::smsAdjustExcessPayment($order->customer, $amount, $request->option);

        if ($request->option["id"] == 1) {
            $order->customer->customerScores()->create([
                "point" => $amount,
                "expiration_date" => \Carbon\Carbon::now()
            ]);
            AlertMessages::smsAddScore($order->customer, $amount);
            AlertMessages::lineAddScore($order->customer, $amount);
        }

        return response()->json([
            "status" => "success",
            "message" => "สร้่างรายการสำเร็จ",
            "title" => "สำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
