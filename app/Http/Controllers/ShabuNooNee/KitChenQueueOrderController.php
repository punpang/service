<?php

namespace App\Http\Controllers\ShaBuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNoonee\KitchenQueueOrder;
use App\ShaBuNooNee\WaitressChannel;
use App\ShabuNooNee\WaitressQueueOrder;
use App\Events\WaitressQueueOrderProcessing;
use Auth;
use Carbon\Carbon;
use App\User;

class KitchenQueueOrderController extends Controller
{
    public function self()
    {
        $data = KitchenQueueOrder::where([
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

        $data = KitchenQueueOrder::where([
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

    public function nextToWaitress(KitchenQueueOrder $kitchen)
    {

        // ค้นหามีหรือยัง
        $checkInsert = WaitressQueueOrder::where("queue_id", $kitchen->queue_id)->first();

        //หากมีแล้ว
        if ($checkInsert) {
            return response()->json(
                [
                    "message" => "รายการอาหารนี้ ถูกจัดไปแล้ว"
                ],
                201
            );
        }

        $channel = WaitressChannel::findQueue();

        WaitressQueueOrder::Waitress($kitchen->queue_id, $channel->id);

        $channel->count = WaitressQueueOrder::countWaitressForChannel($channel);
        $channel->save();

        $kitchen->status_done = true;
        $kitchen->save();

        $useTime = \Carbon\Carbon::parse($kitchen->updated_at)->diff($kitchen->created_at);
        $messageUseTime = "ใช้เวลาไป " . $useTime->i . " นาที ";

        broadcast(new WaitressQueueOrderProcessing("alert"));

        return response()->json(
            [
                "message" => $channel->title,
                "messageText" => $messageUseTime
            ],
            200
        );
    }

    public function broadcastNextToWaitress(KitchenQueueOrder $kitchen)
    {
        broadcast(new WaitressQueueOrderProcessing($kitchen));
        return response()->json([
            "message" => "ระบบกำลังทำงาน"
        ], 200);
    }

    public function getToWaitress(KitchenQueueOrder $kitchen)
    {
        $channel = WaitressChannel::QueueFree();
        dd($channel);
        if ($channel->id === request("channel")) {
            $data = WaitressQueueOrder::where([
                ["queue_id", $kitchen->id]
            ])->first();

            if (!$data) {
            }
        }

        return "NOOOO";

        $data = WaitressQueueOrder::where([
            ["queue_id", $kitchen->id]
        ])->first();

        if ($data) {
            return response()->json([
                "data" => $data
            ], 200);
        } else {
            $channel = WaitressChannel::QueueFree();
            if ($channel->id === request("channel")) {
                dd($channel);
                WaitressQueueOrder::Waitress($kitchen->queue_id, $channel->id);

                $channel->count = WaitressQueueOrder::countWaitressForChannel($channel);
                $channel->save();

                $kitchen->status_done = true;
                $kitchen->save();
            }
        }
    }
}
