<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\MSms;
use App\OTP;
use App\Helper;

class OTPController extends Controller
{
    public function store()
    {
        request()->validate([
            'phoneNumber' => 'digits:10|numeric|regex:/[0][0-9]/' //|unique:customers,phone
        ], [
            'phoneNumber.digits' => 'โปรดกรอกหมายเลขโทรศัพท์ 10 หลัก',
            'phoneNumber.regex' => 'โปรดกรอกขึ้นต้นด้วยเลข 0 เท่านั้น',
            'phoneNumber.numeric' => 'โปรดกรอกเป็นตัวเลขเท่านั้น',
        ]);

        //ค้นหา จากเบอร์ และสถานะเป็น 0
        $data = OTP::where([
            ["phoneNumber", request("phoneNumber")],
            ["status", 0]
        ])->orderBy('created_at', "desc")
            ->first();

        // เช็ค หากรายการล่าสุด สร้างเกิน 15 นาที ให้สร้างใหม่ //หากไม่มีใช้รายการล่าสุด

        if ($data == null or \Carbon\Carbon::now()->timestamp - $data->created_at->timestamp > 300) {
            //สร้างใหม่ หรือ ผ่านการเช็ด
            $input = request()->all();
            $input['ref1'] = Str::random(6);
            $input['ref2'] = Helper::randomNumber(6);
            $data = OTP::create($input);
        }

        if ($data->limit > 2) {
            return response()->json([
                'message' => "คุณกดรับรหัสมากเกินไป โปรดลองใหม่อีกครั้งภายหลัง (เว้นระยะ 10 นาที)",
                "status" => 500
            ], 200);
        }

        $data->limit = $data->limit + 1;
        $data->update();

        $message = "รหัสOTP=" . $data->ref2 . " อ้างอิง=" . $data->ref1 . " รหัสมีอายุ 5 นาที by PUNPANG";
        MSms::sms($data->phoneNumber, $message);

        return response()->json([
            "data" => [
                "ref1" => $data->ref1,
                "limit" => $data->limit,
                //"ref2" => $data->ref2
            ],
            "message" => "โปรดรอรับรหัส OTP ที่ SMS",
            "status" => 200
        ], 200);
    }

    public function verify()
    {
        request()->validate([
            'phoneNumber' => 'digits:10|numeric|regex:/[0][0-9]/', //|unique:customers,phone
            "ref1" => "required",
            "ref2" => "digits:6"
        ], [
            'phoneNumber.digits' => 'โปรดกรอกหมายเลขโทรศัพท์ 10 หลัก',
            'phoneNumber.regex' => 'โปรดกรอกขึ้นต้นด้วยเลข 0 เท่านั้น',
            'phoneNumber.numeric' => 'โปรดกรอกเป็นตัวเลขเท่านั้น',
            "ref1.required" => "ref1 ห้ามเว้นว่าง",
            "ref2.digits" => "ref2 ตัวเลข 6 หลักเท่านั้น"
        ]);

        $data = OTP::wherePhonenumber(request("phoneNumber"))
            ->whereRef1(request("ref1"))
            ->whereRef2(request("ref2"))
            ->whereStatus(0)
            ->first();

        if($data == null){
            return response()->json([
                "status" => 501,
                "message" => "ไม่พบการยืนยันตัวตนในระบบ โปรดลองอีกครั้ง"
            ], 200);
        }

        if (\Carbon\Carbon::now()->timestamp - $data->created_at->timestamp > 300) {
            return response()->json([
                "status" => 500,
                "message" => "รหัส OTP หมดอายุ โปรดทำรายการใหม่"
            ], 200);
        }

        $data->status = 1;
        $data->update();

        return response()->json([
            "status" => 200,
            "verified" => true,
            "message" => "ยืนยันตัวจนสำเร็จ"
        ], 200);
    }

    public function destroy()
    {
    }
}
