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
        $data = User::whereType(5)->with("table")->with("table.diningTableStatus")->select("name", "id")->get();
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

        $getPriceRange = PriceRange::getPriceRange(request("priceRange"));
        $sumPrice = (request("count.count_Infant") * $getPriceRange->price_Infant) +
            (request("count.count_Children") * $getPriceRange->price_Children) +
            (request("count.count_Adolescence") * $getPriceRange->price_Adolescence) +
            (request("count.count_Adult") * $getPriceRange->price_Adult) +
            (request("count.count_Elder") * $getPriceRange->price_Elder);

        $data = new DiningTable;
        $data->user_id = request("tableNumber");

        $data->count_Infant = request("count.count_Infant");
        $data->count_Children = request("count.count_Children");
        $data->count_Adolescence = request("count.count_Adolescence");
        $data->count_Adult = request("count.count_Adult");
        $data->count_Elder = request("count.count_Elder");

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
}
