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

        $start_time = $request["times"]["start"];
        $end_time =  $request["times"]["end"];

        if ($start_time > $end_time) {
            return [
                "status" => "error",
                "message" => "เวลาสิ้นสุด น้อยกว่า เวลาเริ่มต้น"
            ];
        }




        $start_date = $request->dates[0] <= $request->dates[1] ? $request->dates[0] : $request->dates[1];
        $end_date = $request->dates[1] >= $request->dates[0] ? $request->dates[1] : $request->dates[0];

        // 14.00 != 00.00 /
        // 15.00 != 23.59 /
        // 21 - 22 -- 21 != 22 /
        if (
            $start_time != "00:00" && $start_date != $end_date ||
            $end_time != "23:30" && $start_date != $end_date
        ) {
            return [
                "status" => "error",
                "message" => "เพิ่มได้ครั้งละวัน"
            ];
        }

        StoreDayOff::create([
            "start_date" => $start_date,
            "end_date" => $end_date,
            "start_time" => $start_time,
            "end_time" => $end_time
        ]);

        return response()->json([
            "status" => "success",
            "message" => "สร้างวันหยุดสำเร็จ"
        ], 200);
    }

    public function remove(StoreDayOff $id)
    {
        $id->delete();
        return response()->json([], 200);
    }
}
