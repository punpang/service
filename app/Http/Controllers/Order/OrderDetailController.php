<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderDetail;
use App\Order\OrderPayment;
use App\Order\Order;
use App\Linenotify;

class OrderDetailController extends Controller
{
    public function store()
    {
        $input = OrderDetail::FormatData(request()->all());
        $detail = OrderDetail::create($input);
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
        $input = OrderDetail::FormatData(request()->all());
        $detail->update($input);
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
        $detail =  OrderDetail::getByOrderIDAll($order_id);
        $payment =  OrderPayment::getDataByOrderIDUseOnly($order_id);
        return response()->json([
            'data' => $detail,
            'sum' => [
                'total' => number_format($detail->sum('sum_price'), 2),
                'deposit' => number_format($payment->sum('amount'), 2),
                'balance' => number_format($detail->sum('sum_price') - $payment->sum('amount'), 2),

            ]
        ], 200);
    }
}
