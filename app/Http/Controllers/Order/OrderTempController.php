<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderTemp;

class OrderTempController extends Controller
{
    public function setTemp()
    {
        $temp = OrderTemp::updateOrCreate(
            ["customer_id" => request("customer.id")],
            ["temp" => json_encode(request("temp"))]
        );

        return response()->json([
            "status" => "success",
            // "temp" => $temp
        ]);
    }

    public function fetch($customer_id)
    {
        $temp = OrderTemp::whereCustomerId($customer_id)->first();
        if (isset($temp)) {
            return $temp;
        }
        
    }
}
