<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\WaitressQueueOrder;
use Auth;

class WaitressQueueOrderController extends Controller
{
    public function self()
    {
        $data = WaitressQueueOrder::where([
            ["user_id", Auth::user()->id],
            ["status_done", 0]
        ])
            ->orWhere([
                ["user_id", 0],
                ["status_done", 0]
            ])
            ->first();

        $data->user_id = Auth::user()->id;
        $data->save();

        $data = WaitressQueueOrder::where([
            ["user_id", Auth::user()->id],
            ["status_done", 0]
        ])
            ->orWhere([
                ["user_id", 0],
                ["status_done", 0]
            ])
            ->with("tableOrderDetails", "tableOrderDetails.product")
            ->first();

        if ($data) {
            return response()->json(
                [
                    "data" => $data,
                    "sumQuantity" => $data->sumQuantity()
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" => "ยังไม่มีรายการอาหาร"
                ],
                200
            );
        }
    }

    public function finished(WaitressQueueOrder $waitress)
    {

        // $waitress = WaitressQueueOrder::where("id", $waitress->id)
        //     ->where("status_done", 0)
        //     ->with("tableOrderDetail.tableOrderId.diningTableId.detailTable")
        //     ->first();
        // return $waitress;

        // ค้นหามีหรือยัง
        $checkInsert = WaitressQueueOrder::where("queue_id", $waitress->queue_id)->where("status_done", 1)->first();

        //หากมีแล้ว
        if ($checkInsert) {
            return response()->json(
                [
                    "message" => "รายการอาหารนี้ ถูกเสิร์ฟไปแล้ว"
                ],
                201
            );
        }

        $waitress->status_done = true;
        $waitress->save();

        $useTime = \Carbon\Carbon::parse($waitress->updated_at)->diff($waitress->created_at);
        $messageUseTime = "ใช้เวลาไป " . $useTime->i . " นาที ";

        $numberTable = $waitress->tableOrderDetail->tableOrderId->diningTableId->detailTable->name;

        return response()->json(
            [
                "message" => "เสิร์ฟ" . $numberTable,
                "messageText" => $messageUseTime
            ],
            200
        );
    }
}
