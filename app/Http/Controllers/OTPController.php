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
            'phone' => 'digits:10|numeric|regex:/[0][0-9]/' //|unique:customers,phone
          ], [
            'phone.digits' => 'โปรดกรอกหมายเลขโทรศัพท์ 10 หลัก',
            'phone.regex' => 'โปรดกรอกขึ้นต้นด้วยเลข 0 เท่านั้น',
            'phone.numeric' => 'โปรดกรอกเป็นตัวเลขเท่านั้น',
          ]);

        //ค้นหา จากเบอร์ และสถานะเป็น 0
        $data = OTP::where([
            ["phoneNumber",request("phoneNumber")],
            ["status",0]
            ])->orderBy('created_at',"desc")
            ->first();

        // เช็ค หากรายการล่าสุด สร้างเกิน 15 นาที ให้สร้างใหม่ //หากไม่มีใช้รายการล่าสุด

        if($data != null and $data->limit > 2){
            return response()->json([
                'message' => "คุณกดรับรหัสมากเกินไป โปรดลองใหม่อีกครั้งภายหลัง",
                "status" => 500
            ], 200 );
        }

        if($data == null or \Carbon\Carbon::now()->timestamp - $data->created_at->timestamp > 900){
            //สร้างใหม่ หรือ ผ่านการเช็ด
            $input = request()->all();
            $input['ref1'] = Str::random(6);
            $input['ref2'] = Helper::randomNumber(6);
            $data = OTP::create($input);            
        }

        $data->limit = $data->limit+1;
        $data->update();

        $message = "รหัสOTP=".$data->ref2." อ้างอิง=".$data->ref1." by PUNPANG";
        MSms::sms($data->phoneNumber,$message);

        return response()->json([
            "data" => [
                "ref1" => $data->ref1,
                "limit" => $data->limit
            ],
            "message" => "โปรดรอรับรหัส OTP ที่ SMS",
            "status" => 200
        ], 200);
    }

    public function verify()
    {

    }

    public function destroy()
    {

    }

}
