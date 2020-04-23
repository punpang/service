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
        Linenotify::send('เพิ่มสินค้า #'.$detail->order_id.'/n รายละ');

        return response()->json(['success' => true], 200);
    }


    public function getByOrderID($order_id)
    {
        $data = OrderDetail::whereOrderId($order_id)->with('Product.ProductTagUseOnly.ProductCategorySubUseOnly.ProductCategory')->with('Product.ProductImage')->get();

        return response()->json([
            'data' => $data,
            'cost' => [
                'sumPrice' => OrderDetail::sumPrice()
            ]
        ], 200);
    }
}
