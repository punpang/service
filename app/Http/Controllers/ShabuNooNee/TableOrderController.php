<?php

namespace App\Http\Controllers\ShabuNooNee;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\TableOrder;
use App\ShabuNooNee\DiningTable;
use App\ShabuNooNee\TableOrderDetail;
use App\ShabuNooNee\ProductGroup;
use App\ShabuNooNee\Product;
use App\ShabuNooNee\KitchenQueueOrder;
use App\ShaBuNooNee\WaitressChannel;
use App\ShabuNooNee\WaitressQueueOrder;
use Auth;
use App\User;
use App\Events\KitchenQueueOrderFetch;
use App\Events\WaitressQueueOrderProcessing;

class TableOrderController extends Controller
{
    public function self()
    {
        $data = DiningTable::findByUserID();
        return response()->json(
            [
                'data' => $data
            ],
            200
        );
    }

    public function selfUUID()
    {
        $data = DiningTable::where("checkAuth", request("uuid"))
            ->whereIn("status_id", [1, 2])
            ->with("detailTable", "priceRange")
            ->first();

        // Check ว่าหมดเวลาหรือยัง
        if ($data->time_end > \Carbon\Carbon::now()) {
        }
        return response()->json(
            [
                'data' => $data
            ],
            200
        );
    }

    public function productGroupAllow()
    {
        $productGroupAllow =  explode(",", request("productGroupAllow"));
        $data = ProductGroup::whereIn("id", $productGroupAllow)
            ->whereStatus(1)
            ->with("product", "product.googlgImage")
            ->get();
        return response()->json(
            [
                'data' => $data
            ],
            200
        );
    }

    public function testStore()
    {
        $input = request()->all();
        dd($input);
        foreach ($input as $key => $value) {
            if ($value == null) {
                unset($key);
            }
        }
        return $input;
    }

    public function store() // เพิ่มรายการสั่งอาหาร และ รายละเอียด
    {
         //dd(request()->all());
        // ตรวจสอบว่า รายการอาหารเกิน 20 ถาดไหม
        if (request("sumCountProduct") > 20) {
            return response()->json(
                [
                    "message" => "รายการอาหารเกิน 20 ถาด"
                ],
                201
            );
        }

        // ตรวจสอบสถานะว่าเป็น "ใช้งานอยู่" [return boolean]
        if (!DiningTable::findByUserIDStatusUse()) {
            return response()->json(
                [
                    "message" => "ไม่สามารถทำการสั่งอาหารได้",
                    "messageText" => "เนื่องจากไม่ได้อยู่ในสถานะใช้งาน",
                    "resetStatus" => true
                ],
                201
            );
        }

        //สร้างรายการอาหารใหม่ (ครัว) เป็นค่าว่าง
        $newTableOrderToKitChen = "";

        //สร้างรายการอาหารใหม่ (เสิร์ฟ) เป็นค่าว่าง
        $newTableOrderToWaitress = "";

        //เก็บสินค้าที่หมด
        $productOutOfStock = "";

        // สร้างรายละเอียดของรายการอาหาร
        foreach (request("products") as $product) {
            // ตรวจสอบว่ามีสินค้าพร้อมเสิร์ฟไหม true คือ มีสินค้า และเพิ่มลงรายละเอียด
            if (Product::checkProductUse($product["id"]) === true) {
                // ตรวจสอบว่าสินค้าที่เข้ามีจำนวนมากกว่า 0
                if ($product["quantity"] > 0) {
                    // next_to = 4 คือ ครัว
                    if ($product["next_to"] === 4) {

                        // สร้างใหม่ ถ้ายังไม่มี สำหรับครัว
                        if ($newTableOrderToKitChen === "") {
                            $newTableOrderToKitChen = new TableOrder;
                            $newTableOrderToKitChen->dining_table_id = request("diningTableId");
                            $newTableOrderToKitChen->save();
                        }
                        $newTableOrderDetail = new TableOrderDetail;
                        $newTableOrderDetail->table_order_id = $newTableOrderToKitChen->id;
                        $newTableOrderDetail->product_id = $product["id"];
                        $newTableOrderDetail->price = $product["price"];
                        $newTableOrderDetail->quantity = $product["quantity"];
                        $newTableOrderDetail->sum_price = $product["sumPrice"];
                        $newTableOrderDetail->status_free = $product["status_free"];
                        $newTableOrderDetail->save();
                    }
                    // next_to = 3 คือ เสิร์ฟ
                    else if ($product["next_to"] === 3) {
                        // สร้างใหม่ ถ้ายังไม่มี สำหรับเสิร์ฟ
                        if ($newTableOrderToWaitress === "") {
                            $newTableOrderToWaitress = new TableOrder;
                            $newTableOrderToWaitress->dining_table_id = request("diningTableId");
                            $newTableOrderToWaitress->save();
                        }
                        $newTableOrderDetail = new TableOrderDetail;
                        $newTableOrderDetail->table_order_id = $newTableOrderToWaitress->id;
                        $newTableOrderDetail->product_id = $product["id"];
                        $newTableOrderDetail->price = $product["price"];
                        $newTableOrderDetail->quantity = $product["quantity"];
                        $newTableOrderDetail->sum_price = $product["sumPrice"];
                        $newTableOrderDetail->status_free = $product["status_free"];
                        $newTableOrderDetail->save();
                    }
                }
            } else {
                $productOutOfStock = $productOutOfStock . " " . $product["title"];
            }
        }


        // ต่อข้อความสำหรับสินค้าที่หมดชั่วคราว สำหรับแจ้งไปยังลูกค้า
        if ($productOutOfStock != "") {
            $messageProductOutOfStock = "สินค้าที่หมดชั่วคราวและอาจไม่ได้รับ : " . $productOutOfStock;
        } else {
            $messageProductOutOfStock = "";
        }

        //ส่งงานให้กับแผนกต่อไป (ครัว)
        //$queueMessageKitchen = "";
        if ($newTableOrderToKitChen) {

            $kitchen = new KitchenQueueOrder;
            $kitchen->dining_table_id = request("diningTableId");
            $kitchen->queue_id = $newTableOrderToKitChen->id;
            $kitchen->save();

            broadcast(new KitchenQueueOrderFetch("alert"));

            //ค้นหาคิวแรกที่ยังไม่ยังไม่เสร็จ :: คิวครัว
            // $queueCountKitchen = KitchenQueueOrder::where("status_done", 0)->first();
            // $queueKitchen = 1 + $kitchen->id - $queueCountKitchen->id;
            // $queueMessageKitchen = "ครัว #" . $queueKitchen;
        }

        // ส่งงานให้กับแผนกต่อไป (เสิร์ฟ)
        //$queueMessageWaitress = "";
        if ($newTableOrderToWaitress) {
            //หาช่องเสิร์ฟที่คิวงานน้อยที่สุด และ อัปเดทล่าสุด
            $channel = WaitressChannel::findQueue();
            // สร้างคิวงานเสิร์ฟ
            WaitressQueueOrder::Waitress(request("diningTableId"), $newTableOrderToWaitress->id, $channel->id);

            // นับจำนวนงานเสิร์ฟของแต่ละช่องเสิร์ฟ // อัปเดทจำนวนงานเสิร์ฟแต่ละช่อง
            $channel->count = WaitressQueueOrder::countWaitressForChannel($channel);
            $channel->save();

            broadcast(new WaitressQueueOrderProcessing("alert"));

            //ค้นหาคิวแรกที่ยังไม่ยังไม่เสร็จ :: คิวเสิร์ฟ
            //$queueMessageWaitress = "เสิร์ฟ #" . $channel->count;
        }

        //ข้อความคิว ครัว / เสิร์ฟ
        // $queue = "คิวของคุณ : " . $queueMessageKitchen . " " . $queueMessageWaitress;

        return response()->json(
            [
                "message" => "สั่งอาหารสำเร็จ",
                //"queue" => $queue,
                "messageProductOutOfStock" => $messageProductOutOfStock
            ],
            200
        );
    }
}
