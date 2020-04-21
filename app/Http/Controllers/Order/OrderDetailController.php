<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderDetail;
use App\Order\Order;

class OrderDetailController extends Controller
{
    public function store()
    {
        OrderDetail::create(request()->all());
        
        $details = OrderDetail::whereOrderId(request('order_id'))->get();
        if($details->count() == 1){
            $order = Order::find(request('order_id'));
            $order->order_status_id = '2';
            $order->update();
        }
        return response()->json('success', 200);
    }
}
