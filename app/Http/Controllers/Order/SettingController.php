<?php

namespace App\Http\Controllers\Order;

use App\Order\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function fetch()
    {
        $setting = Setting::first();
        return $setting;
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        $setting->update($request->setting);
        return $setting;
    }
}
