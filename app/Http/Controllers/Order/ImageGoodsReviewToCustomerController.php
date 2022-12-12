<?php

namespace App\Http\Controllers\Order;

use App\Order\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Order\AlertMessages;

class ImageGoodsReviewToCustomerController extends Controller
{
    public function store(OrderDetail $detail_id, Request $request)
    {
        $img_id = [];
        foreach ($request->imgs as $img) {
            $img_id[] = [
                "google_image_id" => $img["id"]
            ];
        }
        $detail_id->imageGoodsReviewToCustomers()->createMany($img_id);

        AlertMessages::smsImageGoodsReviewToCustomer($detail_id->aOrder);
        AlertMessages::socialImageGoodsReviewToCustomer($detail_id);

        return response()->json([
            "status" => "success"
        ], 200);
    }

    public function delete(OrderDetail $detail_id, Request $request)
    {
        $imageGoodsReviewToCustomer = $detail_id->imageGoodsReviewToCustomers()->where("id", $request->image_from_customer_id)->first();
        Storage::cloud()->delete($imageGoodsReviewToCustomer->googleImage->src_name);
        $imageGoodsReviewToCustomer->delete();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
