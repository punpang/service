<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\TableOrder;
use App\ShabuNooNee\DiningTable;
use Auth;

class TableOrderController extends Controller
{
    public function self()
    {
        $data = DiningTable::whereUserId(Auth::user()->id)->whereIn("status_id", [1, 2, 3])->first();
        return $data;
    }
}
