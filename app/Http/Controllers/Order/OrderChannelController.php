<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderChannel;

class OrderChannelController extends Controller
{
    public function fetchUse()
    {
        $data = OrderChannel::whereStatusUse(1)->get();
        return $data;
    }
}
