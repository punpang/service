<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\CategorySub;

class CategorySubController extends Controller
{
    public function fetch()
    {
        $data = CategorySub::get();
        return response()->json($data, 200);
    }

    public function getRelationship($id)
    {
        dd($id);
    }
}
