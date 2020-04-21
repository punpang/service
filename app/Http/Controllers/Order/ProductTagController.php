<?php

namespace App\Http\Controllers\Order;

use App\Order\ProductTag;
use App\Order\ProductCategorySub;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function GuzzleHttp\Promise\all;

class ProductTagController extends Controller
{
    public function tag($id)
    {
        $data = ProductTag::UseOnly()->where('product_id', $id)->with('ProductCategorySub.ProductCategory')->get();
        return response()->json($data, 200);
    }
    public function store()
    {
        ProductTag::where('product_id', request('product_id'))->delete();

        foreach (request('product_category_sub_id') as $key => $value) {

            $data = new ProductTag;
            $data->product_id = request('product_id');
            $data->product_category_sub_id = $value;
            $data->status = true;
            $data->save();

            $sub = ProductCategorySub::find($value);
            if ($sub->status == false) {
                $data->status = $sub->status;
                $data->save();
            }
        }

        //$datas = ProductTag::where('product_id', request('product_id'))->get();

        return 'success';
        //return response()->json($datas, 200);
    }

    public function isProductTags($id)
    {
        $datas = ProductTag::UseOnly()->where('product_id', $id)->get();

        foreach ($datas as $newData) {
            $data[] = $newData->product_category_sub_id;
        }

        if (isset($data)) {
            return response()->json($data, 200);
        }

        return ['data' => 'noData'];
    }
}
