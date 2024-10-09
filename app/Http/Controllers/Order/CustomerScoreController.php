<?php

namespace App\Http\Controllers\Order;

use App\Order\ACustomer;
use App\Order\CustomerScore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerScoreController extends Controller
{
    public function add_point_by_pos(Request $request)
    {
        $customer = ACustomer::firstOrCreate(["tel" => $request->phone], ["name" => "ลูกค้า", "social" => "0", "social_is" => "-"]);

        $amount = $request->amount;

        // if ($customer->created_at >= now()->subMinutes(1)) {
        //     $amount = $customer->request->amount * 2;
        // } else {
        //     $amount = $customer->request->amount;
        // }
        // 15:01:59
        // 15:02:01 >= 15:01:59
        //
        // $amount = $customer->created_at >= now()->subMinutes(1)
        //     ? $request->amount * 2 : $request->amount;

        // dd($amount, $customer->created_at, now()->subMinutes(1));
        CustomerScore::addScore($customer, $amount);

        return response()->json([
            "title" => "เพิ่มคะแนนสำเร็จ",
            "icon" => "success",
            // 'message' => "เพิ่มคะแนนเรียบร้อย",
            // "results" => $add_score
        ], 200);
    }
}
