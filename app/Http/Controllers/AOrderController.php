<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AOrder;

class AOrderController extends Controller
{
    public function DashboardToday()
    {
      $orders = AOrder::OrderTodayConfirm()->orderBy('time_get','ASC')->get();
      return view('admin/order/dashboard/today',compact('orders'));
    }
}
