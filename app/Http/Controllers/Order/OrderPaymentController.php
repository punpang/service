<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderPayment;

class OrderPaymentController extends Controller
{
    public function create()
    {
        $data = OrderPayment::create(request()->all());

        return $data;
    }
}
