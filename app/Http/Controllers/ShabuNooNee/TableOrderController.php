<?php

namespace App\Http\Controllers\ShabuNooNee;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\TableOrder;
use App\ShabuNooNee\DiningTable;
use App\ShabuNooNee\TableOrderDetail;
use App\ShabuNooNee\ProductGroup;
use App\ShabuNooNee\Product;
use App\ShabuNooNee\KitchenQueueOrder;
use App\ShabuNooNee\WaitressQueueOrder;
use Auth;
use App\User;

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
        $checkTohKitchen = collect([1, 2, 3, 4, 5]);

        //สร้างรายการอาหารใหม่ (เสิร์ฟ) เป็นค่าว่าง
        $newTableOrderToWaitress = "";
        $checkToWaitress = collect([6, 7]);

        //เก็บสินค้าที่หมด
        $productOutOfStock = "";

        // สร้างรายละเอียดของรายการอาหาร
        foreach (request("products") as $product) {
            // ตรวจสอบว่ามีสินค้าพร้อมเสิร์ฟไหม true คือ มีสินค้า และเพิ่มลงรายละเอียด
            if (Product::checkProductUse($product["id"]) === true) {
                // ตรวจสอบว่าสินค้าที่เข้ามีจำนวนมากกว่า 0
                if ($product["quantity"] > 0) {
                    // กลุ่มสินค้า 12345 ไปครัว
                    if ($checkTohKitchen->has($product["product_group_id"])) {

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
                    } // กลุ่มสินค้า 67 ไปเสิร์ฟ
                    //else if ($checkToWaitress->has($product["product_group_id"])) {
                    else {
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



        // ส่งงานให้กับแผนกต่อไป (ครัว)
        $queueMessageKitchen = "";
        if ($newTableOrderToKitChen) {

            $kitchen = new KitchenQueueOrder;
            $kitchen->queue_id = $newTableOrderToKitChen->id;
            $kitchen->save();

            //ค้นหาคิวแรกที่ยังไม่ยังไม่เสร็จ :: คิวครัว
            $queueCountKitchen = KitchenQueueOrder::where("status_done", 0)->first();
            $queueKitchen = 1 + $kitchen->id - $queueCountKitchen->id;
            $queueMessageKitchen = "ครัว #" . $queueKitchen;
        }
        // ส่งงานให้กับแผนกต่อไป (เสิร์ฟ)
        $queueMessageWaitress = "";
        if ($newTableOrderToWaitress) {
            $Waitress = new WaitressQueueOrder;
            $Waitress->queue_id = $newTableOrderToWaitress->id;
            $Waitress->save();

            //ค้นหาคิวแรกที่ยังไม่ยังไม่เสร็จ :: คิวเสิร์ฟ
            $queueCountWaitress = WaitressQueueOrder::where("status_done", 0)->first();
            $queueWaitress = 1 + $Waitress->id - $queueCountWaitress->id;
            $queueMessageWaitress = "เสิร์ฟ #" . $queueWaitress;
        }

        //ข้อความคิว ครัว / เสิร์ฟ
        $queue = $queueMessageKitchen . " " . $queueMessageWaitress;

        return response()->json(
            [
                "message" => "สั่งอาหารสำเร็จ",
                "queue" => $queue,
                "messageProductOutOfStock" => $messageProductOutOfStock
            ],
            200
        );
    }
}
