<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\CategoryDetail;

class CategorySubRelationshipController extends Controller
{
    public function getRelationship($id)
    {
        return CategoryDetail::find($id);
    }
}
