<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\DiningTable;
use App\ShabuNooNee\PriceRange;
use App\User;

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
        if (DiningTable::checkTable(request("tableNumber"))) {
            return response()->json([
                "status" => "success",
                "message" => "โต๊ะนี้ ถูกเปิดใช้งานแล้ว"
            ], 201);
        }

        $getPriceRange = PriceRange::getPriceRange(request("count.priceRange_id"));
        $sumPrice = (request("count.count_Infant") * $getPriceRange->price_Infant)
            + (request("count.count_Children") * $getPriceRange->price_Children)
            + (request("count.count_Adolescence") * $getPriceRange->price_Adolescence)
            + (request("count.count_Adult") * $getPriceRange->price_Adult)
            + (request("count.count_Elder") * $getPriceRange->price_Elder);

        $data = new DiningTable;
        $data->user_id = request("tableNumber");

        $data->count_Infant = request("count.count_Infant");
        $data->count_Children = request("count.count_Children");
        $data->count_Adolescence = request("count.count_Adolescence");
        $data->count_Adult = request("count.count_Adult");
        $data->count_Elder = request("count.count_Elder");
        $data->sum_customer = request("count.sumCountCustomer");

        $data->time_end = \Carbon\Carbon::now()->addMinutes('90');

        $data->price_Infant = $getPriceRange->price_Infant;
        $data->price_Children = $getPriceRange->price_Children;
        $data->price_Adolescence = $getPriceRange->price_Adolescence;
        $data->price_Adult = $getPriceRange->price_Adult;
        $data->price_Elder = $getPriceRange->price_Elder;
        $data->sumPrice = $sumPrice;
        $data->priceRange_id = $getPriceRange->id;
        $data->save();

        return response()->json([
            "status" => "success",
            "message" => "เปิดโต๊ะใหม่สำเร็จ"
        ], 200);
    }

    public function tableUpdate(DiningTable $id)
    {

        //dd(request()->all());
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

        $data = DiningTable::Table($id->id);

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
}
