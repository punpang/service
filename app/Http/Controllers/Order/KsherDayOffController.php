<?php

namespace App\Http\Controllers\Order;

use App\Order\KsherDayOff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KsherDayOffController extends Controller
{
    public function fetch(Request $request)
    {
        // dd($request->get("sort_asc"));
        $query = KsherDayOff::query();

        if (
            $request->get("isStartNow") != "undefined" &&
            $request->get("isStartNow") == true
        ) {
            $query->where("day_off", ">=", now()->format("Y-m-d"));
        }

        if ($request->get("sort_asc") != "undefined") {
            $query->orderBy($request->get("sort_asc"), "ASC");
        }

        $query->with("ksherChannelPayment");

        return $query->get();
    }

    public function remove(KsherDayOff $id)
    {
        $id->delete();
        return response()->json([], 200);
    }
}
