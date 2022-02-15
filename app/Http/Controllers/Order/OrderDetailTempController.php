<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderDetailTemp;

class OrderDetailTempController extends Controller
{
    public function create()
    {
        // dd(request()->all());
        $temp = new OrderDetailTemp;
        $temp->order_temp_id = request("order_temp.id");
        $temp->temp = json_encode(request("product"));
        $temp->save();

        return response()->json([
            "status" => "success",
            "temp" => $temp
        ]);
    }

    public function fetch($order_temp_id)
    {
        $temps = OrderDetailTemp::whereOrderTempId($order_temp_id)->get();
        return $temps;
    }
}
