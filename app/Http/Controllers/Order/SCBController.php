<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SCBPayment;
use App\Linenotify;

class SCBController extends Controller
{
    public function deeplink($amount,$ref1,$ref2)
    {
        //dd(Str::random(40));
        return SCBPayment::CreateDeeplink($amount,$ref1,$ref2);
    }

    public function callback()
    {      
        return request()->all();
        
        return Linenotify::send("TEST SCB");
    }
}
