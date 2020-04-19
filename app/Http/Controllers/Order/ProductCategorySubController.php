<?php

namespace App\Http\Controllers\Order;

use App\Order\ProductCategorySub;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\ProductCategory;
use App\Order\ProductTag;

class ProductCategorySubController extends Controller
{
    public function get()
    {
        $data = ProductCategorySub::with("ProductCategory")->get();

        return response()->json($data, 200);
    }

    public function useOnly()
    {
        $data = ProductCategorySub::UseOnly()->with("ProductCategory")->orderBy("product_category_id", 'ASC')->get();
        return response()->json($data, 200);
    }


    public function store()
    {
        $data = ProductCategorySub::create(request()->all());
        return response()->json($data, 200);
    }

    public function update(ProductCategorySub $id)
    {
        $id->update(request()->all());
        $id->save();

        ProductCategory::where([
            ['id', $id->product_category_id],
            ['status', false]
        ])->update(['status' => true]);

        ProductTag::where('product_category_sub_id', $id->id)->update(['status' => $id->status]);

        return response()->json($id, 200);
    }
}
