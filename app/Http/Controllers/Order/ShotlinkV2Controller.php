<?php

namespace App\Http\Controllers\Order;

use App\Order\ShotlinkV2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShotlinkV2Controller extends Controller
{
    public function redirect($shotlink)
    {
        ShotlinkV2::where("expiration_date", "<", now())
            ->orWhere("number_of_access_rights", "<=", 0)
            ->delete();

        $shotlink = ShotlinkV2::where("shot_link", $shotlink)->first();
        if ($shotlink == null) {
            return response()->json([
                "status" => "error",
                "title" => "ลิงก์หมดอายุ",
                "icon" => "error"
            ], 200);
        }

        $shotlink->update([
            "number_of_access_rights" => ($shotlink->number_of_access_rights - 1)
        ]);

        return $shotlink->full_link;
    }
}
