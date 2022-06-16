<?php

namespace App\Http\Controllers\Order;

use App\Order\FacebookReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacebookReplyController extends Controller
{
    public function fetch()
    {
        $data = FacebookReply::with("webhooks")->get();
        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success",
            "reply" => $data
        ], 200);
    }

    public function store(Request $request)
    {

        $text = str_replace("\n", "\r\n", $request["text"]);

        FacebookReply::create([
            "text" => json_encode($text, true)
        ]);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success",
        ], 200);
    }

    public function update(FacebookReply $reply, Request $request)
    {
        $cut_r = str_replace("\r", "", $request["text"]);
        $text = str_replace("\n", "\r\n", $cut_r);

        $reply->update([
            "text" => json_encode($text, true)
        ]);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success",
        ], 200);
    }
}
