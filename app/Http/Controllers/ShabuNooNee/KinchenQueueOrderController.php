<?php

namespace App\Http\Controllers\ShaBuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNoonee\KitchenQueueOrder;
use Auth;

class KinchenQueueOrderController extends Controller
{
    public function self()
    {
        $data = KitchenQueueOrder::where([
            ["user_id", Auth::user()->id],
            ["status_done", 0]
        ])
            ->orWhere([
                ["user_id", 0],
                ["status_done", 0]
            ])
            ->with("tableOrderDetails", "tableOrderDetails.products")
            ->first();

        $data->user_id = Auth::user()->id;
        $data->save();
        $data->sumQuantity();

        return response()->json(
            [
                "data" => $data,
                "sumQuantity" => $data->sumQuantity()
            ],
            200
        );
    }
}
