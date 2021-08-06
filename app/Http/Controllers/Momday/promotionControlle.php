<?php

namespace App\Http\Controllers\Momday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Momday\promotion;

class promotionControlle extends Controller
{
    public function fetchAll()
    {
        $data = promotion::where("status_use", 1)
            ->where('date_start', "<=", now()->format("Y-m-d")) // 3 <= 4
            ->where('date_end', ">=", now()->format("Y-m-d")) // 3 >= 4
            ->orderBy("date_get", "asc")
            ->get();

        return response()->json($data, 200);
    }

    public function fetchAllByID($promotion_id)
    {
        dd($promotion_id);
    }
}
