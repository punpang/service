<?php

namespace App\Http\Controllers\Order;

use App\Order\ChannelOfPurchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelOfPurchaseController extends Controller
{
    public function UseOnly()
    {
        $data = ChannelOfPurchase::UseOnly()->get();

        return response()->json($data, 200);
    }
}
