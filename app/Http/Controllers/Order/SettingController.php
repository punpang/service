<?php

namespace App\Http\Controllers\Order;

use App\Order\Setting;
use Illuminate\Http\Request;
use App\Order\KsherChannelPayment;
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

        // $getChanges = $setting->getChanges();
        // if (isset($getChanges["ksher_is_use"])) {
        //     KsherChannelPayment::where("group", "KSHER")->update(["status_use" => $getChanges["ksher_is_use"]]);
        // }

        return $setting;
    }
}
