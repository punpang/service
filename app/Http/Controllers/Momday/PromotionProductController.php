<?php

namespace App\Http\Controllers\Momday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Momday\promotion;
use App\Momday\PromotionProduct;

class PromotionProductController extends Controller
{
    public function fetchByPromotionID($promotion_id)
    {
        $promotion = promotion::DateInStartEnd($promotion_id);
        // ->with("usePromotionProducts");

        if (!$promotion) {
            return response()->json(
                [
                    "msgTitle" => "ไม่มีโปรโมชั่นนี้",
                    "msgText" => "เนื่องจากอาจยังไม่ถึงกำหนดเปิดโปรโมชั่น หรือ โปรโมชั่นอาจสิ้นสุดแล้ว"
                ],
                201
            );
        }

        $promotion->usePromotionProducts;

        return response()->json(
            $promotion,
            200
        );
    }
}
