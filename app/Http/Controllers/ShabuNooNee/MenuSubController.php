<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNoonee\MenuSub;

class MenuSubController extends Controller
{
    public function all()
    {
        $data = MenuSub::with("menuMain")->get();
        //return $data;
        $g = $data->groupBy("title_main", true);

        return $g;
    }

    public function changeSub(MenuSub $id)
    {
        //dd(request("key"));
        $id->update(
            [request("key") => request("value")]
        );
    }
}
