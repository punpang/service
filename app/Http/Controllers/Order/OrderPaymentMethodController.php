<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderPaymentMethod;

class OrderPaymentMethodController extends Controller
{
    public function all()
    {
        $data = OrderPaymentMethod::all();
        return response()->json($data, 200);
    }

    public function useonly()
    {
        $data = OrderPaymentMethod::whereStatus(1)->get();
        return response()->json($data, 200);
    }
    
}
