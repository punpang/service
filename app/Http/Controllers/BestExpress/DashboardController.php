<?php

namespace App\Http\Controllers\BestExpress;

use App\BestExpress\Tracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
      $trackings = Tracking::get();
      return $trackings->sum('total').$trackings->sum('shipping_charge');
    }
}
