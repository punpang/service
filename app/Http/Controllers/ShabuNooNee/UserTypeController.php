<?php

namespace App\Http\Controllers\ShaBuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNoonee\UserType;

class UserTypeController extends Controller
{
    public function nextTo()
    {
        $data = UserType::whereIn("id", [3, 4])->get();

        return response()->json(
            ["data" => $data],
            200
        );
    }
}
