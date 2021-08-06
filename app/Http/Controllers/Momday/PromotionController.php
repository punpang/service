<?php

namespace App\Http\Controllers\Momday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Momday\Order;
use App\Momday\OrderStatus;
use App\Momday\promotion;

class PromotionController extends Controller
{
    public function fetchAll()
    {
        $data = promotion::where("status_use", 1)
            ->where('date_start', "<=", now()->format("Y-m-d")) // 3 <= 4
            ->where('date_end', ">=", now()->format("Y-m-d")) // 3 >= 4
            ->orderBy("date_get", "asc")
            ->get();

        return response()->json($data, 200);
    }

    public function fetchAllByID($promotion_id)
    {
        $promotion = promotion::where("id", $promotion_id)->first();

        $orders = Order::where("promotion_id", $promotion_id)
            ->with("orderDetails.product", "orderStatus", "customer")
            ->get();

        $order_status = OrderStatus::get();

        return response()->json(
            [
                "promotion" => $promotion,
                "orders" => $orders->groupBy("order_status_id"),
                "order_status" => $order_status
            ],
            200
        );
    }
}
