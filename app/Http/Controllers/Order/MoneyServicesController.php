<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\MoneyServices;

class MoneyServicesController extends Controller
{
    public function store(Request $request)
    {
        $data = new MoneyServices;
        $data->order_detail_id = $request->order_detail_id;
        $data->category_money_service_id = $request->category_money_service_id;
        $data->fee = $request->fee;
        $data->thb20 = $request->thb20;
        $data->thb50 = $request->thb50;
        $data->thb100 = $request->thb100;
        $data->thb500 = $request->thb500;
        $data->thb1000 = $request->thb1000;
        $data->note = $request->note;
        $data->save();

        return $data;
    }

    public function update(MoneyServices $id, Request $request)
    {
        $id->category_money_service_id = $request->category_money_service_id;
        $id->fee = $request->fee;
        $id->thb20 = $request->thb20;
        $id->thb50 = $request->thb50;
        $id->thb100 = $request->thb100;
        $id->thb500 = $request->thb500;
        $id->thb1000 = $request->thb1000;
        $id->note = $request->note;
        $id->save();
        return response()->json($id, 201);
    }

    public function delete(MoneyServices $id)
    {
        $id->delete();
        return response()->json([
            "title" => "ลบข้อมูลสำเร็จ",
            "icon" => 'success'
        ], 200);
    }
}
