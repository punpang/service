<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\Order\AOrder;
use App\Order\Coupons;
use App\Order\CouponUsed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponUsedController extends Controller
{
    public function useCoupon(Request $request)
    {
        $order = AOrder::find($request->order_id);
        $result = Coupons::processingCouponsReturnDiscount($request->code, $order->sumGoods(), $order->customer->id);

        if ($result["status"] == "success") {
            $data = CouponUsed::create([
                "coupon_id" => $result["coupon"]["id"],
                "discount" => $result["discount"],
                "order_id" => $order->id
            ]);

            return response()->json(
                [
                    "icon" => "success",
                    "title" => "ใช้โค้ดส่วนลดสำเร็จ"
                ],
                200
            );
        } else {
            return response()->json(
                $result,
                200
            );
        }
    }
}
