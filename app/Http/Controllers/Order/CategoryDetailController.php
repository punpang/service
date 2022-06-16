<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\CategoryDetail;
use App\Order\CategoryRelationship;

class CategoryDetailController extends Controller
{
    public function getSize()
    {
        $data = CategoryDetail::where("category_id", 1)
            ->where("status_use", 1)
            ->get();

        return response()->json($data, 200);
    }

    public function getCakeTexture($sizeID)
    {
        $CategoryRelationships = CategoryRelationship::where("relationship_1", $sizeID)
            ->whereStatusUse(1)
            ->get();

        foreach ($CategoryRelationships as $Category) {
            $data[] = $Category->categoryDetail;
        }

        return response()->json($data, 200);
    }

    public function getCategoryRelationship1($relationship1)
    {
        $data = CategoryRelationship::getRelationship1($relationship1);
        return response()->json($data, 200);
    }

    public function getCategoryRelationship2($relationship2)
    {
        $data = CategoryRelationship::getRelationship2($relationship2);
        return response()->json($data, 200);
    }
}
