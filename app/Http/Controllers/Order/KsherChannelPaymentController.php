<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Order\KsherChannelPayment;

class KsherChannelPaymentController extends Controller
{
    public function getUseKsherChannelPayment()
    {
        $kshers = KsherChannelPayment::whereStatusUse(true)->orderBy("sort", "ASC")->get();
        return $kshers;
    }
    
}
