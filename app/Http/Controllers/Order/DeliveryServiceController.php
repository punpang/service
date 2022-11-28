<?php

namespace App\Http\Controllers\Order;

use App\Order\AOrder;
use App\Order\AlertMessages;
use Illuminate\Http\Request;
use App\Order\DeliveryService;
use App\Http\Controllers\Controller;


class DeliveryServiceController extends Controller
{
    public function store(AOrder $order, Request $request)
    {
        if ($order->orderDeliveryService()->count() >= 1) {
            return response()->json([
                'status' => "failed",
                "message" => "มีบริการจัดส่งสำหรับรายการสั่งซื้อนี้อยู่แล้ว",
                "icon" => "error",
                "title" => "ผิดพลาด"
            ], 201);
        }

        $order->orderDeliveryService()->create([
            "recipient_name" => $request->form["recipient_name"],
            "recipient_phone" => $request->form["recipient_phone"],
            "delivery_fee" => $request->form["delivery_fee"],
            "link_google_maps" => $request->form["link_google_maps"],
            "detail" => $request->form["detail"]
        ]);

        $order->update(["status_full_payment", 1]);

        return response()->json([
            'status' => "success",
            "message" => "สร้างรายการสำหรับบริการจัดส่งสำเร็จ",
            "icon" => "success",
            "title" => "สำเร็จ"
        ], 200);
    }

    public function update(DeliveryService $delivery_service, Request $request)
    {
        $delivery_service->update([
            "recipient_name" => $request->form["recipient_name"],
            "recipient_phone" => $request->form["recipient_phone"],
            "delivery_fee" => $request->form["delivery_fee"],
            "link_google_maps" => $request->form["link_google_maps"],
            "detail" => $request->form["detail"]
        ]);

        $delivery_service->aOrder->update(["status_full_payment", 0]);

        return response()->json([
            'status' => "success",
            "message" => "แก้ไขข้อมูลสำหรับบริการจัดส่งเรียบร้อย",
            "icon" => "success",
            "title" => "สำเร็จ"
        ], 200);
    }

    public function remove(DeliveryService $delivery_service)
    {
        $delivery_service->delete();

        return response()->json([
            'status' => "success",
            "message" => "ลบบริการจัดส่งสำเร็จ",
            "icon" => "success",
            "title" => "สำเร็จ"
        ], 200);
    }

    public function shipping(DeliveryService $delivery_service, Request $request)
    {
        // dd($request->rider);
        // dd($delivery_service->AOrder->status);
        if ($delivery_service->AOrder->status != 8) {
            return response()->json([
                'status' => "error",
                "message" => "ไม่อยู่ในสถานะที่จัดส่งได้",
                "icon" => "error",
                "title" => "ผิดพลาด"
            ], 201);
        }

        if ($delivery_service->AOrder->sum_all["sumBalance"] != 0) {
            return response()->json([
                'status' => "error",
                "message" => "ตรวจสอบยอดคงเหลือ",
                "icon" => "error",
                "title" => "ผิดพลาด"
            ], 201);
        }

        $delivery_service->update($request->rider);
        $delivery_service->update(["status" => "shipping"]);

        AlertMessages::lineShippingGoods($delivery_service->AOrder);
        AlertMessages::smsShippingGoods($delivery_service->AOrder);


        return response()->json([
            'status' => "success",
            "message" => "กำลังจัดส่งสินค้า",
            "icon" => "success",
            "title" => "สำเร็จ"
        ], 200);
    }

    public function success(DeliveryService $delivery_service)
    {
        $delivery_service->update(["status" => "success"]);

        AlertMessages::lineDeliverySuccessGoods($delivery_service->AOrder);
        AlertMessages::smsDeliverySuccessGoods($delivery_service->AOrder);

        return response()->json([
            'status' => "success",
            "message" => "จัดส่งสินค้าเรียบร้อย",
            "icon" => "success",
            "title" => "สำเร็จ"
        ], 200);
    }
}
