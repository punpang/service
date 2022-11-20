<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\Tags;
use App\Order\OrderTags;

class TagsController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        // $tag = Tags::where("text", $request->text)->first();
        // if ($tag) {
        //     return;
        // }

        $tags = Tags::updateOrCreate(
            ["text" => $request->text],
            ["color" => $request->color]
        );

        return response()->json([
            "tag" => $tags,
            "title" => "สร้างสำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function tags_store(Request $request)
    {
        OrderTags::where("order_detail_id", $request->order_detail_id)->delete();

        foreach ($request->tags as $tag) {
            if (isset($tag["id"])) {
                OrderTags::create([
                    "tag_id" => $tag['id'],
                    "order_detail_id" => $request->order_detail_id
                ]);
            } else {
                $getTag = Tags::where("text", $tag["text"])->first();
                OrderTags::create([
                    "tag_id" => $getTag->id,
                    "order_detail_id" => $request->order_detail_id
                ]);
            }
        }

        return response()->json(
            ["title" => "เพิ่ม Tag เรียบร้อย", 'icon' => "success"],
            200
        );
    }

    public function fetch(Request $request)
    {
        $query = Tags::query();

        return $query->get();
    }

    public function edit_tag(Tags $id, Request $request)
    {
        $id->update([
            "text" => $request->text
        ]);

        return;
    }
}
