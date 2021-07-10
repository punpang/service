<?php

namespace App\Http\Controllers\ShabuNooNee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShabuNooNee\GoogleImage;
use Image;
use Storage;

class GoogleImageController extends Controller
{
    public function store()
    {

        //request()->validate([
          //  'image'  => 'required|image|mimes:jpeg,png,jpg|max:9999'
        //]);

        $fileName = request()->file('image')->store('', 'google');

        $listContents = Storage::disk('google')->listContents();

        foreach ($listContents as $listContent) {
            if ($listContent['name'] == $fileName) {

                $data = new GoogleImage;
                $data->src_name = $listContent['path'];
                $data->save();
            }
        }

        return response()->json($data, 200);
    }

    public function store_old()
    {
        request()->validate([
            'image'  => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $image = request()->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();

        $data = new GoogleImage;
        $data->src_name = $image_name;
        $data->save();

        if ($data) {

            $destinationPath = public_path('/images');
            $resize_image = Image::make($image->getRealPath());
            $resize_image->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $image_name);
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $image_name);

            return response()->json($data, 200);
        }

        return ['response' => 'error'];
    }

    public function update(Product $id)
    {
        request()->validate([
            'image'  => 'required|image|mimes:jpeg,png,jpg|max:9999'
        ]);

        $fileName = request()->file('image')->store('', 'google');

        $listContents = Storage::disk('google')->listContents();

        foreach ($listContents as $listContent) {
            if ($listContent['name'] == $fileName) {

                $data = new GoogleImage;
                $data->src_name = $listContent['path'];
                $data->save();

                $id->product_image_id = $data->id;
                $id->update();
            }
        }

        return response()->json($data, 200);
    }

    public function update_lod(Product $id)
    {
        request()->validate([
            'image'  => 'required|image|mimes:jpeg,png,jpg|max:9999'
        ]);

        $image = request()->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();

        $data = new GoogleImage;
        $data->src_name = $image_name;
        $data->save();

        if ($data) {
            $destinationPath = public_path('/images');
            $resize_image = Image::make($image->getRealPath());

            $resize_image->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $image_name);
            $image->move($destinationPath, $image_name);

            $id->product_image_id = $data->id;
            $id->update();

            return response()->json($data, 200);
        }

        return $response = "error";
    }

    public function destroy(GoogleImage $id)
    {
        $product = Product::where('product_image_id', $id->id)->first();

        if ($product) {
            $product->product_image_id = "1";
            $product->update();
        }

        /*
        if ($id->id != "1") {
            $filePath = $id->src_name;
            $path = public_path('/images');

            if (file_exists($path . '/' . $filePath)) {
                unlink($path . '/' . $filePath);
                $id->delete();
                return "success";
            }
        } else if ($id->id == "1") {
            return "success == 1";
        }
        */

        return ['success' => true];
    }
}
