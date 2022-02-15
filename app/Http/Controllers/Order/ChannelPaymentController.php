<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\ChannelPayment;

class ChannelPaymentController extends Controller
{
    public function getUse()
    {
        $datas = ChannelPayment::whereStatusUse(1)->get();
        return $datas;
    }
}
