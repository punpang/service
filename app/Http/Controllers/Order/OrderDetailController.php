<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderDetail;
use App\Order\Order;
use App\Linenotify;

class OrderDetailController extends Controller
{
    public function store()
    {
        //dd(request()->all());
        $detail = OrderDetail::create(request()->all());
        $order = Order::whereId(request('order_id'))->whereOrderStatusId(1)->first();
        if (isset($order)) {
            $order->order_status_id = '2';
            $order->update();
        }
        Linenotify::send('เพิ่มสินค้า #' . $detail->order_id . '/n รายละ');

        return response()->json(['success' => true], 200);
    }

    public function update(OrderDetail $detail)
    {
        $detail->update(request()->all());
        Linenotify::send('แก้ไขสินค้า #' . $detail->order_id . '/n รายละ');

        return response()->json(['success' => true], 200);
    }

    public function delete(OrderDetail $detail)
    {
        $detail->update(['status' => '0']);
        Linenotify::send('ลบสินค้า #' . $detail->order_id);

        return response()->json(['success' => true], 200);
    }

    public function redelete(OrderDetail $detail)
    {
        $detail->update(['status' => '1']);
        Linenotify::send('เรียกคืนสินค้า #' . $detail->order_id);

        return response()->json(['success' => true], 200);
    }


    public function getByOrderID($order_id)
    {
        return response()->json([
            'data' => OrderDetail::getByOrderIDAll($order_id),
            'cost' => [
                'sumPrice' => OrderDetail::sumPrice($order_id)
            ]
        ], 200);
    }
}
