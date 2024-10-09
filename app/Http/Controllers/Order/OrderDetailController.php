<?php

namespace App\Http\Controllers\Order;


use App\Order\AOrder;
use App\Events\OrderEvent;
use App\Order\OrderDetail;
use App\Order\ProductAddOn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderDetailController extends Controller
{
    public function fetch(Request $request)
    {
        //$query = OrderDetail::query();

        $query = OrderDetail::
            // with([
            //     "aOrder" => function ($q) {
            //         $q->select("id", "date_get", "time_get");
            //         // $q->orderBy("time_get", "asc");
            //     }
            // ])->
            with(
                "aOrder:id,date_get,time_get,status",
                "aOrder.orderDeliveryService",
                "aOrder.aStatus",
                "aPrice.googleImage",
                "addOns.productAddOn.goodsAddOn",
                "imageFromCustomers.googleImage",
                "productPrototypes.googleImage"
            )
            ->whereHas("aOrder", function ($q) use ($request) {
                $q->where("date_get", $request->get("date_get"));
                $q->where("status", "<", "8");
            })
            ->get();



        foreach ($query as $q) {
            $q->aOrder->setAppends(["time_get_format"]);
        }

        return $query->makeHidden(["sum_all"]);
    }

    public function fetch_pre_order_lists()
    {
        //$query = OrderDetail::query();



        $query = OrderDetail::
            // with([
            //     "aOrder" => function ($q) {
            //         $q->select("id", "date_get", "time_get");
            //         // $q->orderBy("time_get", "asc");
            //     }
            // ])->
            with(
                "aOrder:id,date_get,time_get,status",
                "aOrder.orderDeliveryService",
                "aOrder.aStatus",
                "aPrice.googleImage",
                "addOns.productAddOn.goodsAddOn",
                "imageFromCustomers.googleImage",
                "productPrototypes.googleImage"
            )
            ->whereHas("aOrder", function ($q) {
                return $q->where("date_get", ">=", now()->addDays(1)->format("Y-m-d"))
                    ->where("status", "<", "8");

                // $q->where("status", "<", "8");
                // $q->orderBy("date_get","ASC");
            })
            // ->sortBy("a_order.date_get")
            ->get();

        // foreach ($query as $q) {
        //     $q->aOrder->orderBy("date_get", "DESC");
        // // }

        // return $query;

        // dd($query->sortBy("aOrder.date_get"));

        // foreach ($query as $q) {
        //     $q->aOrder->orderBy(["date_get", "ASC"]);
        // }


        foreach ($query as $q) {
            $q->aOrder->setAppends(["time_get_format", "date_get_th"]);
        }



        return $query->makeHidden(["sum_all"]);
    }



    public function delete(OrderDetail $id)
    {
        $id->delete();

        return response()->json([
            "status" => "success",
        ], 200);
    }

    public function update(OrderDetail $id, Request $request)
    {
        // dd($request);
        $id->update([
            "a_price_id" => $request->a_price["id"],
            "price" => $request->a_price["price"],
            "message" => $request->message,
            "detail" => $request->detail
        ]);

        // return $id->aPrice->m3;
        if ($id->aPrice->m3 == 2) {
            $id->status_upload_images_from_customer = 1;
            $id->save();
        }

        return response()->json([
            "status" => "success",
        ], 200);
    }

    public function createAddOn(OrderDetail $id, Request $request)
    {
        $id->addOn()->create([
            "product_add_on_id" => $request->add_on["id"],
            "price" => $request->add_on["price"],
        ]);

        return response()->json([
            "status" => "success",
        ], 200);
    }

    public function deleteAddOn(OrderDetail $id, Request $request)
    {
        $id->addOn()->where("id", $request->add_on["id"])->first()->delete();

        return response()->json([
            "status" => "success",
        ], 200);
    }

    public function autoUpdateAddOns(OrderDetail $id, Request $request)
    {
        foreach ($request->add_ons as $add_on) {
            $product_add_on = ProductAddOn::where("goods_add_on_id", $add_on["product_add_on"]["goods_add_on_id"])
                ->where("am4_id", $request->m4)->first();
            // dd($product_add_on);
            if (isset($product_add_on)) {
                $id->addOn()->where("id", $add_on["id"])->update([
                    "product_add_on_id" => $product_add_on->id,
                    "price" => $product_add_on->price
                ]);
                // $id->addOn()->where("id", $add_on["id"])->delete();
                // $id->addOn()->create([
                //     "product_add_on_id" => $product_add_on->id,
                //     "price" => $product_add_on->price
                // ]);
            }
        }

        return response()->json([
            "status" => "success",
        ], 200);
    }

    public function switchStatusUploadImagesFromCustomer(OrderDetail $detail, Request $request)
    {
        $detail->status_upload_images_from_customer = $request->status_upload_images_from_customer;
        $detail->update();

        return response()->json([
            "status" => "success",
        ], 200);
    }


    public function switchIsTakeAPhoto(OrderDetail $detail, Request $request)
    {
        $detail->is_take_a_photo = $request->is_take_a_photo;
        $detail->update();

        return response()->json([
            "status" => "success",
        ], 200);
    }

    public function fetch_for_menu(Request $request)
    {
        // $explodes = explode(",", $request->get("tags"));
        // return $explodes;
        // return $request->get("tags");
        $query = OrderDetail::query();

        $query->select("id", "order_id", "a_price_id", "order_detail_id");
        $query->whereHas("aOrder", function ($q) {
            $q->whereDate("date_get", "<=", now()->subDays(1)->format("Y-m-d"));
        });

        if ($request->get("tags") != null) {
            $tags = explode(",", $request->get("tags"));
            foreach ($tags as $tag) {
                $query->whereHas("orderTag.tag", function ($q) use ($tag) {
                    $q->where("text", $tag);
                });
            }



            // $query->whereHas("orderTag.tag", function ($q) use ($request) {
            //     $tags = explode(",", $request->get("tags"));
            //     // foreach ($tags as $tag) {
            //     //     $q->where("text", $tag);
            //     // }
            //     // $q->where("text", "มินิมอล");
            //     // $q->where("text", "คัพเค้ก");

            //     $q->whereIn("text", $tags);
            // });
        }

        // $query->orderBy("a_order.time_get", "DESC");
        $query->orderBy("id", "DESC");

        $query->whereHas("imageForMenus");

        $query->with(
            // "aOrder:id",
            //"imageForMenus:id,google_image_id,order_detail_id",
            "imageForMenus.googleImage:id,src_name",
            "aPrice",
            "addOns:id,order_detail_id,product_add_on_id",
            "addOns.productAddOn.goodsAddOn",
            "orderTags.tag:id,text",
            "multiCakes:id,a_price_id,order_detail_id,sort_group_multi_cake",
            "multiCakes.addOns:id,order_detail_id,product_add_on_id",
            "multiCakes.addOns.productAddOn.goodsAddOn",
            "multiCakes.aPrice"
        );
        $query = $query->get();

        foreach ($query as $q) {
            $q->setAppends(["sum_price_for_menu", "sum_price_multi_cake_for_menu"]);
            // dd($q->multiCakes);
            foreach ($q->multiCakes as $m) {
                $m->setAppends([]);
            }
        }

        if ($request->price_rank != null) {
            $query = $query->where("sum_price_for_menu", "<=", $request->price_rank)
                ->sortBy("sum_price_for_menu");
        }

        $query = $query->makeHidden(["sum_all", "sum_money_customer", "sum_money_service"]);

        return  $query;
    }

    public function update_sort_group_multi_cake(Request $request)
    {
        foreach ($request->all() as $detail) {
            OrderDetail::where("id", $detail["detail_id"])->update([
                "sort_group_multi_cake" => $detail["sort_group_multi_cake"]
            ]);
        }

        return response()->json([
            "success" => true,
            "icon" => "success",
            "text" => "เปลี่ยนแปลงลำดับเรียบร้อย",
            "title" => "ดำเนินการเรียบร้อย"
        ], 200);
    }

    public function remove_muticake(OrderDetail $id)
    {
        $detail_id = $id->order_detail_id;

        $id->order_detail_id = null;
        $id->sort_group_multi_cake = null;
        $id->save();

        $details = OrderDetail::where("order_detail_id", $detail_id)
            ->orderBy("sort_group_multi_cake", "ASC")
            ->get();



        if ($details->count() <= 1) {
            foreach ($details as $detail) {
                $detail->order_detail_id = null;
                $detail->sort_group_multi_cake = null;
                $detail->save();
            }
        } else {

            for ($i = 0; $i < $details->count(); $i++) {
                // dd("FOR", $details->count(), $details[$i]);
                $details[$i]->sort_group_multi_cake = $i + 1;
                $details[$i]->save();
            }
        }

        return response()->json([
            // "data" => $details,
            "success" => true,
            "icon" => "success",
            "text" => "ลบรายการออกเรียบร้อย",
            "title" => "ดำเนินการเรียบร้อย"
        ], 200);
    }

    public function add_multi_cake(OrderDetail $id, Request $request)
    {
        $details = OrderDetail::where("order_detail_id", $request->order_detail_id)->get();

        if ($details->count() == 0) {
            OrderDetail::where("id", $request->order_detail_id)->update([
                "order_detail_id" => $request->order_detail_id,
                "sort_group_multi_cake" => 1
            ]);
            $id->order_detail_id = $request->order_detail_id;
            $id->sort_group_multi_cake = 2;
            $id->save();
        } else {
            $id->order_detail_id = $request->order_detail_id;
            $id->sort_group_multi_cake = $details->count() + 1;
            $id->save();
        }

        return response()->json([
            // "data" => $details,
            "success" => true,
            "icon" => "success",
            "text" => "เพิ่มรายการออกเรียบร้อย",
            "title" => "ดำเนินการเรียบร้อย"
        ], 200);
    }
}
