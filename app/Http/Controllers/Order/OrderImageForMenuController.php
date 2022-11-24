<?php

namespace App\Http\Controllers\Order;

use App\Order\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OrderImageForMenuController extends Controller
{
    public function store(OrderDetail $detail_id, Request $request)
    {
        $img_id = [];
        foreach ($request->img as $img) {
            $img_id[] = [
                "google_image_id" => $img["id"]
            ];
        }
        $detail_id->imageForMenus()->createMany($img_id);

        return response()->json([

            "status" => "success"
        ], 200);
    }

    public function delete(OrderDetail $detail_id, Request $request)
    {
        $imageForMenu = $detail_id->imageForMenus()->where("id", $request->image_from_customer_id)->first();
        Storage::cloud()->delete($imageForMenu->googleImage->src_name);
        $imageForMenu->delete();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
