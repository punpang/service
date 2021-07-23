<?php

namespace App\Http\Controllers\Shabunoonee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shabunoonee\CookingType;

class CookingTypeController extends Controller
{
    public function get()
    {
        $data = CookingType::where("status",1)->get();
        return response()->json($data, 200);
    }
}
