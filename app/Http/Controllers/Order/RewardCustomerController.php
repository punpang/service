<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\RewardCustomer;
use App\Helper;
use App\Linenotify;

class RewardCustomerController extends Controller
{
    public function getByUUID()
    {
        $uuid = request("uuid");

        $findCustomer = RewardCustomer::whereUuid($uuid)
            ->with("labels.reward")
            // ->with("labels.group")
            ->first();

        if (Helper::expiredCheck($findCustomer->updated_at)) {
            return response()->json([
                "message" => "ลิงก์หมดอายุ"
            ], 204);
        }

        return $findCustomer;
    }

    public function endpointPayment()
    {
        Linenotify::send("true");
        return "true";
    }
}
