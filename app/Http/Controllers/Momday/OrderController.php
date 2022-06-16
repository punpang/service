<?php

namespace App\Http\Controllers\Momday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Momday\Order;
use App\Momday\orderDetail;
use Illuminate\Support\Str;
use App\Momday\customer;
use App\Momday\promotion;
use App\MSms;
use Bitly;
use App\URL;

class OrderController extends Controller
{

    public function mainWeb()
    {
        return view('app');
    }

    public function store(Request $request)
    {
        //return $request;

        $customer = customer::where("phone_number", $request->customer["phone_number"])
            ->first();

        if (!$customer) {
            $customer = customer::create($request->customer);
        }

        $overDateEnd = promotion::overDateEnd($request->promotion_id);

        if ($overDateEnd) {
            return response()->json(
                [
                    "msgTitle" => "รายการสั่งซื้อไม่สำเร็จ",
                    "msgText" => "เนื่องจากอาจยังไม่ถึงกำหนดเปิดโปรโมชั่น หรือโปรโมชั่นอาจสิ้นสุดแล้ว"
                ],
                201
            );
        }

        $uuid = Str::uuid();
        $link = URL::base() . "/order/" . $uuid;
        $bitly = Bitly::getUrl($link);

        $order = new Order;
        $order->customer_id = $customer->id;
        $order->promotion_id = $request->promotion_id;
        $order->sum_price_normal = $request->sum["price_normal"];
        $order->sum_price_special = $request->sum["price_special"];
        $order->sum_discount = $request->sum["discount"];
        $order->time_get = Order::queue($request->promotion_id);
        $order->uuid = $uuid;
        $order->url = $bitly;
        $order->save();

        foreach ($request->products as $product) {
            $orderDetail = new orderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $product['id'];
            $orderDetail->price = $product['price_special'];
            $orderDetail->save();
        }

        $msgSms = "ปั้นแป้ง สวัสดีค่ะ ท่านทำรายการสั่งซื้อสำเร็จแล้ว" .
            " #ขั้นตอนต่อไป คือ ชำระเงินและอัปโหลดสลิปการชำระเงิน โดยคลิกลิงก์ (สรุปรายการและเลขที่บัญชี) [ " . $order->url . " ] โปรดชำระทั้งหมด ( " . number_format($request->sum["price_special"], 2)  . " บ. ) ภายในวันที่ " . $order->promotion->date_end .
            " #ทางร้านขอสงวนสิทธิ์ในการจัดลำดับการมอบสินค้าให้ท่านที่ชำระเงินก่อน
            #หากชำระตอนนี้ คุณอาจได้รับคิว " . $order->time_get . " น.
            #หากพบปัญหาโทร. 091-885-3402";

        $msgText =  "ขั้นตอนต่อไป คือ ชำระเงินและอัปโหลดสลิปการชำระเงิน โปรดชำระทั้งหมด ( " . number_format($request->sum["price_special"], 2)  . " บ. ) ภายในวันที่ " . $order->promotion->date_end .
            " #ทางร้านขอสงวนสิทธิ์ในการจัดลำดับการมอบสินค้าให้ท่านที่ชำระเงินก่อน
            #หากชำระตอนนี้ คุณอาจได้รับคิว " . $order->time_get . " น.
            #หากพบปัญหาโทร. 091-885-3402";

        MSms::Sms($customer->phone_number, $msgSms);

        return response()->json(
            [
                'msgTitle' => "ทำรายการสำเร็จ",
                "msgText" => $msgText,
                "uuid" => $order->uuid
            ],
            200
        );
    }

    public function fetchByUUID($uuid)
    {

        $order = Order::where("uuid", $uuid)
            ->with(
                "customer",
                "promotion",
                "orderStatus",
                "payment.paymentStatus",
                "orderDetails.product"
            )
            ->first();

        if ($order->status_use === 1) {
            $overDateEnd = Order::overDateEnd($order->promotion->date_end);
            if ($overDateEnd) {
                $order->status_use = 0;
                $order->order_status_id = 6;
                $order->save();

                return $this->fetchByUUID($uuid);
            }
        }

        return response()->json(
            $order,
            200
        );
    }

    public function fetchByID($order_id)
    {

        $order = Order::where("id", $order_id)
            ->with(
                "customer",
                // "promotion",
                "orderStatus",
                // "orderDetails",
                // "payment.paymentStatus",
                "orderDetails.product",
                // "orderDetails.product.promotion"
            )
            ->first();

        return response()->json(
            $order,
            200
        );
    }

    public function updateStatusGoodsDone(Order $order)
    {
        if ($order->order_status_id !== 3) {
            return response()->json([
                "msgTitle" => "ผิดพลาด",
                "msgText" => "ไม่อยู่ในสถานะสั่งซื้อสำเร็จ"
            ], 200);
        }

        if ($order->status_use === 0) {
            return response()->json([
                "msgTitle" => "ผิดพลาด",
                "msgText" => "สถานะ : ไม่ได้ใช้งานแล้ว",
                "icon" => "warning"
            ], 200);
        }

        $order->order_status_id = 4;
        $order->save();

        $msgSms = "เราจัดเตรียมสินค้าสำหรับคุณเรียบร้อยแล้ว สามารถรับสินค้าได้ทันที โปรดแจ้งชื่อหรือเบอร์โทรเพื่อรับสินค้าของคุณ";
        MSms::Sms($order->customer->phone_number, $msgSms);

        return response()->json([
            "msgTitle" => "สำเร็จ",
            "msgText" => "แจ้งลูกค้าเรียบร้อย",
            "icon" => "success"
        ], 200);
    }

    public function updateStatusGoodsGet(Order $order)
    {
        if ($order->order_status_id !== 4) {
            return response()->json([
                "msgTitle" => "ผิดพลาด",
                "msgText" => "ไม่อยู่ในสถานะสั่งซื้อสำเร็จ"
            ], 200);
        }

        if ($order->status_use === 0) {
            return response()->json([
                "msgTitle" => "ผิดพลาด",
                "msgText" => "สถานะ : ไม่ได้ใช้งานแล้ว",
                "icon" => "warning"
            ], 200);
        }

        $order->order_status_id = 5;
        $order->save();

        $msgSms = "ท่านรับสินค้าเรียบร้อยแล้ว ขอบพระคุณค่ะ";
        MSms::Sms($order->customer->phone_number, $msgSms);

        return response()->json([
            "msgTitle" => "สำเร็จ",
            "msgText" => "แจ้งลูกค้าเรียบร้อย",
            "icon" => "success"
        ], 200);
    }
}
