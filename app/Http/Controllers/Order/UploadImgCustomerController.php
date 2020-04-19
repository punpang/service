<?php

namespace App\Http\Controllers\Order;

use App\Order\UploadImgCustomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadImgCustomerController extends Controller
{
    public function upload($order_id , $auth_key)
    {
      $upload = UploadImgCustomer::where([
        ['id_order',$order_id],
        ['auth',$auth_key]
      ])->firstOrFail();

      if ($upload->image_customer == null) {
        return view('order.customer.upload.image.select_pics',compact('upload'));
      }else {
        return view('order.customer.upload.image.fails');
      }
    }

    public function store()
    {
      request()->validate([
        'pic' => 'max:100'
      ],[
        'pic.max' => 'หมายเลขโทรศัพท์ : เฉพาะตัวเลขเท่านั้น'
      ]);
      dd(request()->all());
      $imageName = request()->file->getClientOriginalName();
      request()->file->move(public_path('upload'), $imageName);


      return response()->json(['uploaded' => '/upload/'.$imageName]);
    }
}
