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
        $order = Order::whereId(request('order_id'))->whereOrderStatusId(1)->first();
        if (isset($order)) {
            $order->order_status_id = '2';
            $order->update();
        }
        return response()->json('success', 200);
    }

    
    public function getByOrderID($order_id)
    {
        $data = OrderDetail::whereOrderId($order_id)->with('Product.ProductTagUseOnly.ProductCategorySubUseOnly.ProductCategory')->with('Product.ProductImage')->get();
        return response()->json($data, 200);
    }
}
