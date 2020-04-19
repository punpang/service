<?php

namespace App\Http\Controllers;

use App\User;
use App\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        dd($user);
        return response()->json($user, 200);
    }
}
