<?php

namespace App\Http\Controllers\ShabuNooNee;

use Image;
use Illuminate\Http\Request;
use App\ShabuNooNee\GoogleImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
//use Storage;

class GoogleImageController extends Controller
{
    public function store()
    {

        //request()->validate([
        //  'image'  => 'required|image|mimes:jpeg,png,jpg|max:9999'
        //]);
        // dd(request()->all());



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

    public function storeNotAuth()
    {
        // request()->validate([
        //  'image'  => 'required|image|mimes:jpeg,png,jpg|max:10'
        // ]);

        // dd(request("is_deleted") != null ? true : true);

        $fileName = request()->file('image')->store('', 'google');

        //$listContents = collect(Storage::disk("google_temps")->listContents());
        $listContents = collect(Storage::cloud()->listContents());

        $content = $listContents->where("name", $fileName)->first();


        $data = GoogleImage::create([
            "src_name" => $content['path'],
            "is_deleted" => request("is_deleted") != null ? request("is_deleted") : false,
        ]);

        return response()->json([
            "image" => [
                "id" => $data->id,
                "src_name" => $data->src_name,
            ],
            "success" => true
        ], 200);
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
