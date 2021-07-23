<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNoonee\BillSaleDetail;
use App\ShabuNooNee\TableOrder;
use App\ShabuNooNee\TableOrderDetail;
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
        // $datas = TableOrder::where('dining_table_id', 1)->with("detailOrderTables")->get();
        // //return $datas;
        // foreach ($datas as $data) {

        //     foreach ($data->detailOrderTables as $key => $value) {
        //         //return $key->product_id;
        //         $products[] =
        //             [
        //                 "product_id" => $value->product_id,
        //                 "quantity" => $value->quantity
        //             ];
        //         // if (!isset($products[$value->product_id])) {
        //         //     $products[] =
        //         //         [
        //         //             "product_id" => $value->product_id,
        //         //             "quantity" => $value->quantity
        //         //         ];
        //         //     //$products[$value->product_id] = $value->quantity;
        //         // } else {
        //         //     //$products[$value->product_id] += $value->quantity;
        //         // }
        //     }
        // }

        // $das = collect($products);

        // $scaknl = $das->groupBy("product_id");

        // foreach ($scaknl  as $scakn) {
        // }
        // return $scaknl;
        // dd("sds");

        // เวลาเฉลี่ยทำงาน
        // $datas = WaitressQueueOrder::where('user_id', 1)
        //     ->whereDate("created_at", now()->format("Y-m-d"))
        //     ->select("user_id", "updated_at", "created_at")
        //     ->get();
        // $count = $datas->count();
        // $sum = 0;
        // foreach ($datas as $data) {
        //     $sum += $data->updated_at->timestamp - $data->created_at->timestamp;
        // }
        // $avgTime = ($sum / $count) / 60;
        // return $avgTime;

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
        

        if ($waitress->format_id === 1) { // format 1
            foreach ($waitress->tableOrderDetails as $tableOrderDetail) {
                //ตรวจสอบว่ามีสินค้าในบิลหรือยัง
                $BillSaleDetail = BillSaleDetail::where("bill_sale_id", $waitress->tableOrder->billSale->id)
                    ->where("product_id", $tableOrderDetail->product_id)
                    ->where("status", 1)
                    ->first();

                if ($BillSaleDetail) //อัปเดท //มี
                {
                    $BillSaleDetail->bill_sale_id = $waitress->tableOrder->billSale->id;
                    $BillSaleDetail->quantity += $tableOrderDetail->quantity;
                    $BillSaleDetail->sum_price += $tableOrderDetail->sum_price;
                    $BillSaleDetail->save();
                } else { //เพิ่ม //ไม่มี
                    $BillSaleDetail = new BillSaleDetail();
                    $BillSaleDetail->bill_sale_id = $waitress->tableOrder->billSale->id;
                    $BillSaleDetail->product_id = $tableOrderDetail->product_id;
                    $BillSaleDetail->price = $tableOrderDetail->price;
                    $BillSaleDetail->quantity = $tableOrderDetail->quantity;
                    $BillSaleDetail->sum_price = $tableOrderDetail->sum_price;
                    $BillSaleDetail->status_free = $tableOrderDetail->status_free;
                    $BillSaleDetail->save();
                }
            }

            $useTime = \Carbon\Carbon::parse($waitress->updated_at)->diff($waitress->created_at);

            if ($useTime->h > 0) {
                $messageUseTime = "ใช้เวลาไป " .  $useTime->h . " ชั่วโมง " . $useTime->i . " นาที " . $useTime->s . " วินาที ";
            } else if ($useTime->i > 0) {
                $messageUseTime = "ใช้เวลาไป " .  $useTime->i . " นาที " . $useTime->s . " วินาที ";
            } else {
                $messageUseTime = "ใช้เวลาไป " . $useTime->s . " วินาที ";
            }

            $numberTable = $waitress->tableOrderDetail->tableOrderId->diningTableId->detailTable->name;
            $nuberChannel = $waitress->waitressChannal->title;
            return response()->json(
                [
                    "message" => $nuberChannel . " ไปยัง " . $numberTable,
                    "messageText" => $messageUseTime
                ],
                200
            );
        }
    }
}
