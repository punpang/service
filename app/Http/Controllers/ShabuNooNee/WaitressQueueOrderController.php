<?php

namespace App\Http\Controllers\ShabuNooNee;

use App\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNoonee\BillSaleDetail;
use App\ShabuNoonee\CookingDetail;
use App\ShabuNooNee\DiningTable;
use App\ShabuNooNee\Product;
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

        // ตรวจสอบสถานะโต๊ะว่าใช้งานอยู่ไหม ถ้าไม่ ให้ลบรายการที่เกี่ยวข้องทั้งหมด
        $checkTableStatusOne = DiningTable::checkTableStatusOne($data->dining_table_id);
        // dd($checkTableStatusOne);
        if (!$checkTableStatusOne) {
            WaitressQueueOrder::where([
                ["dining_table_id", $data->dining_table_id],
                ["status_done", 0]
            ])->delete();
            return response()->json(
                [
                    "message" => "โต๊ะนี้ ชำะเงินไปแล้ว"
                ],
                201
            );
        }

        $data->user_id = Auth::user()->id;
        $data->save();

        if ($data->format_id === 1) {

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


            // อัปเดทสถานะรายการสั่งซื้อเป็น 3 (รอเสิร์ฟ)
            TableOrder::setStatus($data->queue_id, 3);

            return response()->json(
                [
                    "data" => $data,
                    "sumQuantity" => $data->sumQuantity()
                ],
                200
            );
        } else if ($data->format_id === 2) { // รูปแบบที่ 2 -- รูปแบบหม้อชาบู เตา - จำนวนถ้วยจาน
            // ค้นหาอีกครั้ง 
            // โดยมีข้อมูลพร้อมส่งออกไปแสดง


            $data = WaitressQueueOrder::where([
                ["user_id", Auth::user()->id],
                ["status_done", 0]
            ])
                ->orWhere([
                    ["user_id", 0],
                    ["status_done", 0]
                ])
                ->with(
                    "tableDiningSelectUserId.detailTable",
                    "channelWaitressSelectTitle",
                    "detailCooking",
                    //"detailCooking.tableDining",
                    "detailCooking.typeCooking",
                    'detailCooking.brothDetails',
                    'detailCooking.brothDetails.product'
                )
                ->first();

            // อัปเดทสถานะขั้นตอนของ CookingDetaile->status_step = 2 (กำลังจัดเตรียม)
            CookingDetail::setStatusStep($data->queue_id, 2);

            // ส่งข้อมูลออกไปแสดง
            return response()->json(
                [
                    "data" => $data,
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
        $checkTableStatusOne = DiningTable::checkTableStatusOne($waitress->dining_table_id);

        if (!$checkTableStatusOne) {
            WaitressQueueOrder::where("dining_table_id", $waitress->dining_table_id)
                ->where("status_done", 0)->delete();
            return response()->json(
                [
                    "message" => "โต๊ะนี้ ชำะเงินไปแล้ว"
                ],
                201
            );
        }

        // ค้นหามีหรือยัง
        $checkInsert = WaitressQueueOrder::where("id", $waitress->id)
            ->where("queue_id", $waitress->queue_id)
            ->where("status_done", 1)
            ->first();

        //หากมีแล้ว
        if ($checkInsert) {
            return response()->json(
                [
                    "message" => "รายการอาหารนี้ ถูกเสิร์ฟไปแล้ว"
                ],
                201
            );
        }

        // update เป็นเสิร์ฟแล้ว
        $waitress->status_done = true;
        $waitress->save();

        WaitressQueueOrder::countWaitressForChannelAll();

        //หมายเลขโต๊ะ
        $numberTable = $waitress->tableDining->detailTable->name;

        // คำนวนเวลาที่ใช้ไป
        $messageUseTime = Helper::messageUseTime($waitress->created_at, $waitress->updated_at);

        if ($waitress->format_id === 1) { // format 1
            foreach ($waitress->tableOrderDetails as $tableOrderDetail) {
                //ตรวจสอบว่ามีสินค้าในบิลหรือยัง
                $BillSaleDetail = BillSaleDetail::where("bill_sale_id", $waitress->tableOrder->billSale->id)
                    ->where("product_id", $tableOrderDetail->product_id)
                    ->where("status", 1)
                    ->first();

                if ($BillSaleDetail) { //อัปเดท //มี
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

            //ช่องเสิร์ฟ
            $numberChannel = $waitress->waitressChannal->title;

            // อัปเดทสถานะรายการสั่งซื้อเป็น 4 (เสิร์ฟแล้ว)
            TableOrder::setStatus($waitress->queue_id, 4);

            return response()->json(
                [
                    "message" => $numberChannel . " ไปยัง" . $numberTable,
                    "messageText" => $messageUseTime
                ],
                200
            );
        } else if ($waitress->format_id === 2) { // format 2
            //ตรวจสอบว่ามีการเสิร์ฟไปหรือยัง ใน CookingDetail
            if ($waitress->detailCooking->status === 1) {
                return response()->json(
                    ["message" => "รายการนี้ ดำเนินการไปแล้ว"],
                    201,
                );
            }

            // ยังไม่มีการเสิร์ฟให้อัปเดทเป็น เสิร์ฟ
            CookingDetail::setStatusStep($waitress->detailCooking->id, 3);

            return response()->json(
                [
                    "message" => "เสิร์ฟไปยัง" . $numberTable,
                    "messageText" => $messageUseTime
                ],
                200
            );
        }
    }


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

}
