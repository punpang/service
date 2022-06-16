<?php

namespace App\Http\Controllers\Order;

use App\Order\StoreDayOff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreDayOffController extends Controller
{
    public function fetch(Request $request)
    {
        $query = StoreDayOff::query();

        if ($request->get("isManage") != "undefined" && $request->get("isManage") == true) {
            $query->where("start_date", ">=", now()->format("Y-m-d"))
                ->orWhere("end_date", ">=", now()->format("Y-m-d"));
            $query->orderBy("start_date", "ASC")->orderBy("end_date", "ASC");
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $start_date = $request->dates[0] <= $request->dates[1] ? $request->dates[0] : $request->dates[1];
        $end_date = $request->dates[1] >= $request->dates[0] ? $request->dates[1] : $request->dates[0];
        StoreDayOff::create([
            "start_date" => $start_date,
            "end_date" => $end_date,
        ]);

        return response()->json([], 200);
    }

    public function remove(StoreDayOff $id)
    {
        $id->delete();
        return response()->json([], 200);
    }
}
