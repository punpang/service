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

        $data = $this->getByOrderIDAll($order_id);
        $sum_price = $this->sumPrice($order_id);
        return response()->json([
            'data' => $data,
            'cost' => [
                'sumPrice' => $sum_price
            ]
        ], 200);
    }

    public function sumPrice($order_id) //รวมเงินเฉพาะที่ใช้งาน
    {
        $dataForSumPrice = OrderDetail::whereOrderId($order_id)->whereStatus(1)->with('Product.ProductTagUseOnly.ProductCategorySubUseOnly.ProductCategory')->with('Product.ProductImage')->get();
        return number_format($dataForSumPrice->sum('sum_price'), 2);
    }

    public function getByOrderIDAll($order_id)
    {
        return OrderDetail::whereOrderId($order_id)->orderBy('status', "DESC")->with('Product.ProductTagUseOnly.ProductCategorySubUseOnly.ProductCategory')->with('Product.ProductImage')->get();
    }
}
