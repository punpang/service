<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\PriceRange;

class PriceRangeController extends Controller
{
    public function all()
    {
        $data = PriceRange::get();
        return response()->json([
            'data' => $data,
            "status" => "success",
            "message" => "โหลดข้อมูลสำเร็จ"
        ], 200);
    }
}
