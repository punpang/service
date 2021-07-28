<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\DiningTable;
use App\ShabuNooNee\PriceRange;
use Illuminate\Support\Str;
use App\User;
use App\Events\DiningTableStatus;
use App\Events\WaitressQueueOrderProcessing;
use App\ShabuNoonee\BillSale;
use App\ShabuNoonee\CookingBroth;
use App\ShabuNoonee\CookingDetail;
use App\ShaBuNooNee\WaitressChannel;
use App\ShabuNooNee\WaitressQueueOrder;
use Auth;

class DiningTableController extends Controller
{
    public function allTable()
    {
        $data = User::whereType(5)
            ->with("table")
            ->select("name", "id")->get();
        return response()->json($data, 200);
    }

    public function table(DiningTable $id)
    {
        $data = DiningTable::Table($id->id);
        return response()->json($data, 200);
    }

    public function store()
    {

        //dd(request()->all());
        // ตรวจสอบว่าโต๊ะเปิดอยู่ไหม
        if (DiningTable::checkTable(request("tableNumber"))) {
            return response()->json([
                "status" => "success",
                "message" => "โต๊ะนี้ ถูกเปิดใช้งานแล้ว"
            ], 202);
        }

        // ตรวจสอบจำนวนลูกค้า ต้องมีตั้งแต่ 1 คน ขึ้นไป
        if (request("data.sumCountCustomer") <= 0) {
            return response()->json([
                "status" => "success",
                "message" => "โปรดเพิ่มจำนวนลูกค้าอย่างน้อย 1 คน"
            ], 201);
        }

        if (
            request("data.count_Adolescence")
            + request("data.count_Adult")
            + request("data.count_Elder") <= 0
        ) {
            return response()->json([
                "status" => "success",
                "message" => "ต้องมีเด็กโต, ผู้ใหญ่ , ผู้สูงอายุ รวมกันอย่างน้อย 1 คน"
            ], 201);
        }

        if (!request("data.cookingType")) {
            return response()->json([
                "status" => "success",
                "message" => "โปรดเพิ่มเตาอย่างน้อย 1 รายการ"
            ], 201);
        }

        // หาราคาแพ็คดเกจ
        $getPriceRange = PriceRange::getPriceRange(request("data.priceRange_id"));
        // คำนวนราคารวมของตามจำนวนคนและช่วงอายุ
        $sumPrice = (request("data.count_Infant") * $getPriceRange->price_Infant)
            + (request("data.count_Children") * $getPriceRange->price_Children)
            + (request("data.count_Adolescence") * $getPriceRange->price_Adolescence)
            + (request("data.count_Adult") * $getPriceRange->price_Adult)
            + (request("data.count_Elder") * $getPriceRange->price_Elder);

        // เปิดโต๊ะ
        $diningtable = new DiningTable;
        $diningtable->user_id = request("tableNumber");

        // จำนวนคนตามช่วงอายุ
        $diningtable->count_Infant = request("data.count_Infant");
        $diningtable->count_Children = request("data.count_Children");
        $diningtable->count_Adolescence = request("data.count_Adolescence");
        $diningtable->count_Adult = request("data.count_Adult");
        $diningtable->count_Elder = request("data.count_Elder");
        $diningtable->sum_customer = request("data.sumCountCustomer");

        // เพิ่มเวลา 90 นาที นับจากการเปิดโต๊ะ
        $diningtable->time_end = \Carbon\Carbon::now()->addMinutes('90');

        // ราคาปัจจุบันใรนแต่ละช่วงอายุ
        $diningtable->price_Infant = $getPriceRange->price_Infant;
        $diningtable->price_Children = $getPriceRange->price_Children;
        $diningtable->price_Adolescence = $getPriceRange->price_Adolescence;
        $diningtable->price_Adult = $getPriceRange->price_Adult;
        $diningtable->price_Elder = $getPriceRange->price_Elder;

        // รวมราคา
        $diningtable->sumPrice = $sumPrice;

        // แพ็คเกจ
        $diningtable->priceRange_id = $getPriceRange->id;

        // สร้าง UUID ไว้สำหรับตรวจสอบการใช้เครื่องลูกค้า
        $diningtable->checkAuth = Str::uuid();
        $diningtable->save();

        // pusher ไปยัง เครื่องลูกค้า ให้เปิดโต๊ะเพื่อสั่งอาหารได้
        broadcast(new DiningTableStatus($diningtable));

        // สร้างบิลสำหรับโต๊ะ
        $billSale = new BillSale;
        $billSale->dining_table_id = $diningtable->id;
        $billSale->user_id = Auth::user()->id;
        $billSale->save();

        // เพิ่มเตา และ ชุดถ้วยจานช้อน (Loop)
        foreach (request("data.cookingType") as $key => $cookingType) {
            $cookingDetail = new CookingDetail;
            $cookingDetail->dining_table_id = $diningtable->id;
            $cookingDetail->cooking_type_id = $cookingType["cookingType"];
            if ($key === 0) {
                $cookingDetail->count_of_dining_equipment = $diningtable->sum_customer;
            }
            $cookingDetail->save();
            foreach ($cookingType["broths"] as $broth) {
                $cookingBroth = new CookingBroth;
                $cookingBroth->cooking_detail_id = $cookingDetail->id;
                $cookingBroth->product_id = $broth["id"];
                $cookingBroth->save();
            }

            WaitressQueueOrder::waitressCreate($cookingDetail->dining_table_id, $cookingDetail->id, 2);
        }

        // //หาช่องเสิร์ฟที่คิวงานน้อยที่สุด และ อัปเดทล่าสุด
        // $channel = WaitressChannel::findQueue();
        // // สร้างคิวงานเสิร์ฟ
        // WaitressQueueOrder::Waitress($diningtable->id, $diningtable->id, $channel->id, 2);

        // // นับจำนวนงานเสิร์ฟของแต่ละช่องเสิร์ฟ // อัปเดทจำนวนงานเสิร์ฟแต่ละช่อง
        // $channel->count = WaitressQueueOrder::countWaitressForChannel($channel);
        // $channel->save();

        // // pusher ไปยัง เสิร์ฟ
        // broadcast(new WaitressQueueOrderProcessing("alert"));

        return response()->json([
            "status" => "success",
            "message" => "เปิดโต๊ะใหม่สำเร็จ"
        ], 200);
    }

    public function tableUpdate(DiningTable $id)
    {

        // //dd(request()->all());
        // return [$id, request("sumCountCustomer")];

        // จำนวนลูกค้าเดิม
        $sumCountCustomerOld = $id->sum_customer;


        // อัปเดทจำนวนลูกค้า
        $data = $id;
        $sumPrice = (request("count_Infant") * $id->price_Infant)
            + (request("count_Children") * $id->price_Children)
            + (request("count_Adolescence") * $id->price_Adolescence)
            + (request("count_Adult") * $id->price_Adult)
            + (request("count_Elder") * $id->price_Elder);

        $data->count_Infant = request("count_Infant");
        $data->count_Children = request("count_Children");
        $data->count_Adolescence = request("count_Adolescence");
        $data->count_Adult = request("count_Adult");
        $data->count_Elder = request("count_Elder");
        $data->sum_customer = request("sumCountCustomer");
        $data->sumPrice = $sumPrice;

        $data->save();
       // return [$sumCountCustomerOld , $data->sum_customer];

        // $datad = DiningTable::Table($id->id);

        // เพิ่มชุดถ้วยจานช้อน เมื่อจำนวนลูกค้าเพิ่มขึ้น
        $diffSumCustomer =  $data->sum_customer - $sumCountCustomerOld;
        if ($diffSumCustomer > 0) {           
            //return "ss"; 
            $cookingDetail = new CookingDetail;
            $cookingDetail->dining_table_id = $data->id;
            $cookingDetail->count_of_dining_equipment = $diffSumCustomer;
            $cookingDetail->save();

            //แจ้งไปยัง เสิร์ฟ
            WaitressQueueOrder::waitressCreate($data->id, $cookingDetail->id, 2);
        }

        return response()->json([
            "data" => $data,
            "status" => "success",
            "message" => "แก้ไขจำนวนลูกค้าสำเร็จ"
        ], 200);
    }
    public function tableChangePriceRange(DiningTable $id)
    {
        //dd(request("priceRange_id"));
        $data = $id;
        //ดาวน์เกรด
        if ($data->priceRange_id > request("priceRange_id")) {
            //เกิน 15 นาที ถดาวเกรดไม่ได้
            if (\Carbon\Carbon::parse($data->created_at)->addMinutes(15)->timestamp < \Carbon\Carbon::now()->timestamp) {
                return response()->json([
                    "status" => "success",
                    "message" => "ไม่สามารถลดแพ็คเกจได้ (เกิน 15 นาที)"
                ], 201);
            }

            //สั่งอาหารหมวดที่ดาวน์เกรดไม่ได้
            if (\Carbon\Carbon::parse($data->created_at)->addMinutes(15)->timestamp < \Carbon\Carbon::now()->timestamp) {
                return response()->json([
                    "status" => "success",
                    "message" => "ไม่สามารถลดแพ็คเกจได้ (สั่งอาหารกลุ่มที่สูงกว่า)"
                ], 201);
            }
        }

        $getPriceRange = PriceRange::getPriceRange(request("priceRange_id"));

        $sumPrice = ($data->count_Infant * $getPriceRange->price_Infant)
            + ($data->count_Children * $getPriceRange->price_Children)
            + ($data->count_Adolescence * $getPriceRange->price_Adolescence)
            + ($data->count_Adult * $getPriceRange->price_Adult)
            + ($data->count_Elder * $getPriceRange->price_Elder);

        //dd($sumPrice);
        $data->price_Infant = $getPriceRange->price_Infant;
        $data->price_Children = $getPriceRange->price_Children;
        $data->price_Adolescence = $getPriceRange->price_Adolescence;
        $data->price_Adult = $getPriceRange->price_Adult;
        $data->price_Elder = $getPriceRange->price_Elder;
        $data->priceRange_id = $getPriceRange->id;
        $data->sumPrice = $sumPrice;
        $data->save();

        $data = DiningTable::Table($id->id);

        return response()->json([
            "status" => "success",
            "message" => "เปลี่ยนแปลงเซทบุฟเฟต์สำเร็จ"
        ], 200);
    }

    public function checkUUID()
    {
        // dd(request()->all());
        $check = DiningTable::where("checkAuth", request("uuid"))
            ->whereIn("status_id", [1, 2])
            ->whereDate("created_at", \Carbon\Carbon::now())
            ->first();


        if ($check === null) {
            //dd($check);
            Auth::logout();
            return response()->json([
                "status" => "logOut"
            ], 200);
        }

        //return "true";
    }
}
