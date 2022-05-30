<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Order\KsherChannelPayment;
use App\Order\KsherDayOff;
use Illuminate\Http\Request;

class KsherChannelPaymentController extends Controller
{
    public function getUseKsherChannelPayment()
    {
        $kshers = KsherChannelPayment::
        WhereDoesntHave("ksherDayOff", function ($query) {
            return $query->where("day_off", \Carbon\Carbon::now()->format('Y-m-d'));
        })
            ->whereStatusUse(true)
            ->orderBy("sort", "ASC")
            ->get();

        return $kshers;
    }

    public function fetch(Request $request)
    {
        $kshers = KsherChannelPayment::query();

        if ($request->get("id")) {
            $kshers->where("id", $request->get("id"));
        }

        if ($request->get("status_use")) {
            $kshers->where("status_use", $request->get("status_use"));
        }

        if ($request->get("orderByASC")) {
            $kshers->orderBy($request->get("orderByASC"), "ASC");
            //$request->get("orderByASC") ชื่อ column
        }

        if ($request->get("orderByDESC")) {
            $kshers->orderBy($request->get("orderByDESC"), "DESC");
            //$request->get("orderByDESC") ชื่อ column
        }

        return $kshers->get();
    }

    public function setDayOff(Request $request)
    {
        // หาวันที่ทั้งหมด
        $date1 = date_create($request->dates[0]);
        $date2 = date_create($request->dates[1]);
        if ($date1 <= $date2) {
            $dateStart = $date1;
            $dateEnd = $date2;
        } else {
            $dateStart = $date2;
            $dateEnd = $date1;
        }
        $dateDiff = date_diff($dateStart, $dateEnd);
        $dayOffs = [];
        for ($i = 0; $i < $dateDiff->days + 1; $i++) {
            array_push($dayOffs, \Carbon\Carbon::parse($dateStart)->addDays($i)->format("Y-m-d"));
        }
        // บันทึกข้อมูล
        foreach ($dayOffs as $dayOff) {
            foreach ($request->checkbox as $checkbox) {
                KsherDayOff::updateOrCreate(
                    [
                        "ksher_channel_payment_id" => $checkbox,
                        "day_off" => $dayOff
                    ]
                );
            }
        }

        return response()->json(
            [
                "status" => "success",
                "title" => "บันทึกวันปิด KSHER สำเร็จ",
                "message" => "บันทึกวันปิด KSHER สำเร็จ",
                "icon" => "success"
            ],
            200
        );
    }
}
