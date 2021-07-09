<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNoonee\MenuMain;
use Auth;

class MenuMainController extends Controller
{
    public function lists()
    {
        if (Auth::check()) {
            $lists = MenuMain::where(Auth::user()->userType->name, 1)->select("id", "title", "action")->with("menuSubs")->get();
            return response()->json($lists, 200);
        }
    }

    public function all()
    {
        $lists = MenuMain::with("menuSubsAll")->get();
        return response()->json($lists, 200);
    }

    public function changeMain(MenuMain $id)
    {
        $id->update(
            [request("key") => request("value")]
        );
    }

    public function storeMain()
    {
        $data = MenuMain::create(request()->all());
        return response()->json([
            "data" => $data,
            "status" => "success",
            "message" => "เพิ่มเมนูหลักสำเร็จ"
        ], 200);
    }

    public function selectMain()
    {
        $data = MenuMain::get();
        return response()->json(
            [
                "data" => $data,
                "status" => "success"
            ],
            200
        );
    }
}
