<?php

namespace App\Http\Controllers\Order;

use App\Order\SmsMessages;
use App\MSms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsMessagesController extends Controller
{
    public function store(Request $request)
    {
        SmsMessages::updateOrCreate([
            "message" => $request->sms["message"]
        ]);

        return response()->json([
            "title" => "สร้างข้อความสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function update(SmsMessages $smsID, Request $request)
    {

        $smsID->update([
            "message" => $request->sms["message"]
        ]);
        return response()->json([
            "title" => "แก้ไขข้อความสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function fetch(Request $request)
    {
        $query = SmsMessages::query();

        if ($request->sortByCount != null) {
            $query->orderBy("count", $request->sortByCount);
        }

        return response()->json([
            "fetch" => $query->get(),
            "title" => "โหลดข้อความสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function send(Request $request)
    {
        $request->validate([
            "sms.phone_number" => "required|numeric|digits_between:10,10|starts_with:0",
            "sms.message" => "required",
            "sms.id" => "numeric"
        ], [
            "sms.phone_number.starts_with" => "ต้องเริ่มต้นด้วย 0"
        ]);

        MSms::sms($request->sms["phone_number"], $request->sms["message"]);

        if (isset($request->sms["id"])) {
            $sms =  SmsMessages::find($request->sms["id"]);
            $sms->count = $sms->count + 1;
            $sms->save();
        }

        return response()->json(
            [
                "title" => "ส่งข้อความแล้ว",
                "icon" => "success",
                "sms" => $request->sms
            ],
            200
        );
    }
}
