<?php

namespace App\Http\Controllers\Order;

use App\Order\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class OrderProductPrototypeController extends Controller
{
    public function store(OrderDetail $detail_id, Request $request)
    {
        $img_id = [];
        foreach ($request->img as $img) {
            $img_id[] = [
                "google_image_id" => $img["id"]
            ];
        }
        $detail_id->productPrototypes()->createMany($img_id);

        return response()->json([

            "status" => "success"
        ], 200);
    }

    public function delete(OrderDetail $detail_id, Request $request)
    {
        $productPrototype = $detail_id->productPrototypes()->where("id", $request->image_from_customer_id)->first();
        Storage::cloud()->delete($productPrototype->googleImage->src_name);
        $productPrototype->delete();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
