<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Order\FacebookWebhook;
use App\Http\Controllers\Controller;

class FacebookWebhookController extends Controller
{
    public function fetch(Request $request)
    {
        $datas = FacebookWebhook::query();
        // dd( $request->get("isNullReply"));

        if (
            $request->get("isNullReply") == true
        ) {
            $datas->where("reply_id", NULL);
        }

        $datas->orderBy("created_at", "DESC");

        return $datas->get();
    }

    public function addReply(FacebookWebhook $webhook, Request $request)
    {
        $webhook->update([
            "reply_id" => $request->reply["id"],
        ]);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success"
        ], 200);
    }

    public function removeReply(FacebookWebhook $webhook)
    {
        $webhook->update([
            "reply_id" => NULL,
        ]);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success"
        ], 200);
    }
}
