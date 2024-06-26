<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\ACustomer;
use Illuminate\Support\Facades\DB;
use FFI\Exception;

class CustomerController extends Controller
{
    public function getSearchByPhoneNumber()
    {
        $data = ACustomer::whereTel(request("phone_number"))->first();
        return $data;
    }

    public function store()
    {
        request()->validate([
            "name" => "required",
            "tel" => "required|unique:order.a_customer|numeric|starts_with:0|digits:10",
            "social_is" => "required"
        ], [
            "name.required" => "ห้ามเว้นว่าง",
            "tel.required" => "ห้ามเว้นว่าง",
            "tel.unique" => "เบอร์นี้ มีในระบบแล้ว",
            "tel.numeric" => "ตัวเลขเท่านั้น",
            "social_is.required" => "ห้ามเว้นว่าง",
        ]);

        DB::beginTransaction();
        try {

            $customer = new ACustomer;
            $customer->name = request('name');
            $customer->tel = request('tel');
            $customer->social = 3;
            $customer->social_is = request('social_is');
            $customer->save();

            DB::commit();

            return $customer;
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update(ACustomer $customer, Request $request)
    {
        // dd($request->name);

        $request->validate([
            "name" => "required",
            "tel" => "required|numeric|starts_with:0|digits:10|unique:order.a_customer,tel," . $request->id,
            "social_is" => "required"
        ], [
            "name.required" => "ห้ามเว้นว่าง",
            "tel.required" => "ห้ามเว้นว่าง",
            "tel.unique" => "เบอร์นี้ มีในระบบแล้ว",
            "tel.numeric" => "ตัวเลขเท่านั้น",
            "social_is.required" => "ห้ามเว้นว่าง",
        ]);

        $customer->update([
            "name" => $request->name,
            "tel" => $request->tel,
            "social_is" => $request->social_is
        ]);

        return response()->json([
            "title" => "แก้ไขเรียบร้อย",
            "icon" => "success"
        ], 200);
    }
}
