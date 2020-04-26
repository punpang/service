<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderPayment;

class OrderPaymentController extends Controller
{
    public function create()
    {   
        $input = OrderPayment::FormatData(request()->all());
        $data = OrderPayment::create($input);

        return response()->json($data, 200);
    }
}
