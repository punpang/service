<?php

namespace App\Http\Controllers\Order;

use App\Order\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\ProductCategorySub;
use App\Order\ProductTag;

class ProductCategoryController extends Controller
{
    public function get()
    {
        $data = ProductCategory::select('id', 'name', 'status')->get();

        return response()->json($data, 200);
    }

    public function useonly()
    {
        $data = ProductCategory::UseOnly()->get();

        return response()->json($data, 200);
    }

    public function UseOnlyWithSubs()
    {
        $data = ProductCategory::UseOnly()->with('productCategorySub')->get();

        return response()->json($data, 200);
    }

    public function store()
    {
        $data = ProductCategory::create(request()->all());

        return response()->json($data, 200);
    }

    public function update(ProductCategory $id)
    {
        $id->update(request()->all());
        $id->save();

        $subs = ProductCategorySub::where('product_category_id', $id->id)->get();
        
        foreach ($subs as $sub) {
            $sub->update(['status' => $id->status]);
            ProductTag::where('product_category_sub_id', $sub->id)->update(['status' => $sub->status]);
        }

        return response()->json($id, 200);
    }
}
