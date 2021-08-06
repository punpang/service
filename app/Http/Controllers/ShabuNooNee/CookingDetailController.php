<?php

namespace App\Http\Controllers\ShabuNoonee;

use App\Events\WaitressQueueOrderProcessing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNoonee\CookingBroth;
use App\ShabuNoonee\CookingDetail;
use App\ShabuNooNee\WaitressQueueOrder;
use Auth;

class CookingDetailController extends Controller
{
    public function store(Request $request)
    {
        $cookingDetail = CookingDetail::store(
            $request->dining_table_id,
            $request->data["cookingType"]
        );

        CookingBroth::store(
            $request->data["broths"],
            $cookingDetail->id
        );

        WaitressQueueOrder::waitressCreate(
            $cookingDetail->dining_table_id,
            $cookingDetail->id,
            2,
            "newCookingDetail"
        );

        return response()->json([
            "msg" => "เพิ่มเตาสำเร็จ"
        ], 200);
    }

    public function fetchDiningTableId($dining_table_id)
    {
        $cookingDetails = CookingDetail::fetchDiningTableId($dining_table_id);

        return response()->json([
            "data" => $cookingDetails
        ], 200);
    }

    public function cancelCookingDetail(CookingDetail $cooking_detail_id)
    {
        // ตรวจสถานะ หากไม่อยู่ในสถานะที่แก้ไขได้        
        //return $cooking_detail_id;
        if (
            $cooking_detail_id->status_step !== 1
            || $cooking_detail_id->waitressUser->status_done !== 0
            || $cooking_detail_id->waitressUser->user_id !== 0
        ) {
            return response()->json([
                "msgTitle" => "ยกเลิกรายการไม่ได้",
                "msgText" => "เนื่องจากรายการนี้ ถูกเปลี่ยนสถานะแล้ว"
            ], 201);
        }

        $cooking_detail_id->status_use = 0;
        $cooking_detail_id->save();

        $cooking_detail_id->waitressUser->user_id = Auth::user()->id;
        $cooking_detail_id->waitressUser->status_done = 1;
        $cooking_detail_id->waitressUser->status_use = 0;
        $cooking_detail_id->waitressUser->save();

        return response()->json(
            ["msg" => "ยกเลิกรายการสำเร็จ"],
            200
        );
    }
}
