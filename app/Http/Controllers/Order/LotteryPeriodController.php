<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\ACustomer;
use App\Order\CustomerScore;
use App\Order\LotteryPeriod;
use App\Order\LotteryRegister;

class LotteryPeriodController extends Controller
{
    public function get_period(ACustomer $customer)
    {
        $date = LotteryPeriod::where("date", ">=", now()->format('Y-m-d'))
            ->whereNull("result")
            ->first();

        if (is_null($date)) {
            return [
                "status" => "error",
                "message" => "ไม่มีงวดรางวัลในขณะนี้"
            ];
        }

        // หางวดที่ไม่มีคนถูก
        $is_awarded_false = LotteryPeriod::is_awarded($date->date, 2);

        // accumulated points for the previous period
        // คะแนนสะสมจากงวดก่อน
        $apotp = $is_awarded_false->sum("cumulative_reward");

        // Number of draws where no one won the prize
        // จำนวนงวดที่ไม่มีคนถูกรางวัล
        // $nodow = $is_awarded_false->count();

        $reserve_lotterys = LotteryRegister::reserve_lotterys($date);

        $lottery_me = LotteryRegister::get_lottery_me($date->id, $customer->id);

        $date = LotteryPeriod::where("date", ">=", now()->format('Y-m-d'))
            ->whereNull("result")
            ->first();

        return [
            "status" => "success",
            "date" => $date,
            "apotp" => $apotp,
            // "nodow" => $nodow,
            "reserve_lotterys" => $reserve_lotterys,
            "lottery_me" => $lottery_me
        ];
    }

    public function register(ACustomer $customer, LotteryPeriod $lottery, Request $request)
    {

        if (\Carbon\Carbon::parse($lottery->date . " 15:00:00")->format("Y-m-d H:i:s") < now()->format('Y-m-d H:i:s')) {
            return [
                "status" => "error",
                "message" => "หมดเวลาลงทะเบียนแล้ว รอประกาศผลนะคะ"
            ];
        }

        $request->validate([
            "lucky_number" => "required"
        ], [
            "lucky_number:required" => "ไม่มีเลขนำโชค"
        ]);

        if ($customer->sumDiffScore < 1) {
            return [
                "status" => "error",
                "message" => "คะแนนไม่พอ"
            ];
        }

        $limit_five = LotteryRegister::where("lottery_period_id", $lottery->id)
            ->where("customer_id", $customer->id)->get();
        if ($limit_five->count() >= 5) {
            return [
                "status" => "error",
                "message" => "คุณลงทะเบียนครบ 5 เลขแล้ว"
            ];
        }

        $find_double = LotteryRegister::where("lottery_period_id", $lottery->id)
            ->where("lucky_number", $request->lucky_number)->first();
        if ($find_double) {
            return [
                "status" => "error",
                "message" => "เลขนำโชคผู้อื่นลงทะเบียนแล้ว"
            ];
        }

        $register = LotteryRegister::create([
            "lottery_period_id" => $lottery->id,
            "lucky_number" => $request->lucky_number,
            "customer_id" => $customer->id
        ]);

        $lottery->update([
            "cumulative_reward" => $lottery->lotteryRegisters->count() //LotteryRegister::where("lottery_period_id", $lottery->id)->count()
        ]);

        CustomerScore::useScore($customer->id, 1);

        return [
            "status" => "success",
            "message" => "ลงทะเบียนเลขนำโชค $request->lucky_number สำหรับงวด " . $register->lotteryPeriod->date_th
        ];
    }
}
