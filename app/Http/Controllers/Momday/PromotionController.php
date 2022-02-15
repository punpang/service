<?php

namespace App\Http\Controllers\Momday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Momday\Order;
use App\Momday\orderDetail;
use App\Momday\OrderStatus;
use App\Momday\promotion;
use App\Momday\PromotionProduct;
use Illuminate\Support\Collection;

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
            ->orderBy("updated_at", "asc")
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

    public function countProduct($promotion_id, $order_status_id)
    {
        $orders = Order::where("promotion_id", $promotion_id)
            ->where("status_use", 1)
            ->where("order_status_id", $order_status_id)
            ->select("id")
            ->get();

        $count = [];
        foreach ($orders as $order) {
            foreach ($order->orderDetails2 as $orderDetail) {
                $count[] = $orderDetail;
            }
        }

        $products = PromotionProduct::where("promotion_id", $promotion_id)->get();

        $collection = collect($count);

        return response()->json(
            [
                "count" => $collection->groupBy("product_id"),
                "products" => $products,
            ],
            200
        );
    }

    public function test($promotion_id)
    {
        $orders_1 = Order::where("promotion_id", $promotion_id)
            ->where("status_use", 1)
            ->where("order_status_id", 1)
            ->select("id")
            ->get();

        foreach ($orders_1 as $order) {
            foreach ($order->orderDetails2 as $orderDetail) {
                $status1[] = $orderDetail;
            }
        }

        $orders_2 = Order::where("promotion_id", $promotion_id)
            ->where("status_use", 1)
            ->where("order_status_id", 2)
            ->select("id")
            ->get();

        foreach ($orders_2 as $order) {
            foreach ($order->orderDetails2 as $orderDetail) {
                $status2[] = $orderDetail;
            }
        }


        $orders_3 = Order::where("promotion_id", $promotion_id)
            ->where("status_use", 1)
            ->where("order_status_id", 3)
            ->select("id")
            ->get();

        foreach ($orders_3 as $order) {
            foreach ($order->orderDetails2 as $orderDetail) {
                $status3[] = $orderDetail;
            }
        }


        $orders_4 = Order::where("promotion_id", $promotion_id)
            ->where("status_use", 1)
            ->where("order_status_id", 4)
            ->select("id")
            ->get();

        foreach ($orders_4 as $order) {
            foreach ($order->orderDetails2 as $orderDetail) {
                $status4[] = $orderDetail;
            }
        }


        $orders_5 = Order::where("promotion_id", $promotion_id)
            ->where("status_use", 1)
            ->where("order_status_id", 5)
            ->select("id")
            ->get();

        foreach ($orders_5 as $order) {
            foreach ($order->orderDetails2 as $orderDetail) {
                $status5[] = $orderDetail;
            }
        }


        $orders_6 = Order::where("promotion_id", $promotion_id)
            ->where("status_use", 1)
            ->where("order_status_id", 6)
            ->select("id")
            ->get();

        foreach ($orders_6 as $order) {
            foreach ($order->orderDetails2 as $orderDetail) {
                $status6[] = $orderDetail;
            }
        }


        $c1 = collect($status1);
        $c2 = collect($status2);
        $c3 = collect($status3);
        $c4 = collect($status4);
        $c5 = collect($status5);
        $c6 = collect($status6);

        return response()->json(
            [
                "status1" => $c1->groupBy("product_id"),
                "status2" => $c2->groupBy("product_id"),
                "status3" => $c3->groupBy("product_id"),
                "status4" => $c4->groupBy("product_id"),
                "status5" => $c5->groupBy("product_id"),
                "status6" => $c6->groupBy("product_id"),
            ],
            200
        );
    }
}
