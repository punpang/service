<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\ACustomer;
use App\Order\AOrder;

class ACustomerController extends Controller
{
    public function confirmConsentConditions()
    {
        $order = AOrder::whereAuthOrder(request("uuid"))->first();
        $order->customer->status_consent_condition = request("status_consent_condition");
        $order->customer->status_consent_condition_updated_at = \Carbon\Carbon::now();
        $order->customer->save();

        return $order->customer;
    }
}
