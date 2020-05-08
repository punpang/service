<?php

namespace App\Http\Controllers\Order;

use App\Helper;
use App\URL;
use Bitly;
use App\Linenotify;
use App\MSms;
use App\Http\Controllers\Controller;
use App\Order\Image;
use App\Order\OrderDetail;
use App\Order\OrderPayment;
use App\Order\Order;
use App\Order\SentLinkForUploadImage;
use Cloudder;

class OrderDetailController extends Controller
{
    public function store()
    {
        $input = OrderDetail::FormatData(request()->all());
        $detail = OrderDetail::create($input);
        $order = Order::whereId(request('order_id'))->whereOrderStatusId(1)->first();
        if (isset($order)) {
            $order->order_status_id = '2';
            $order->update();
        }
        Linenotify::send('เพิ่มสินค้า #' . $detail->order_id . '/n รายละ');

        return response()->json(['success' => true], 200);
    }

    public function update(OrderDetail $detail)
    {
        $input = OrderDetail::FormatData(request()->all());
        $detail->update($input);
        Linenotify::send('แก้ไขสินค้า #' . $detail->order_id . '/n รายละ');

        return response()->json(['success' => true], 200);
    }

    public function delete(OrderDetail $detail)
    {
        $detail->update(['status' => '0']);
        Linenotify::send('ลบสินค้า #' . $detail->order_id);

        return response()->json(['success' => true], 200);
    }

    public function redelete(OrderDetail $detail)
    {
        $detail->update(['status' => '1']);
        Linenotify::send('เรียกคืนสินค้า #' . $detail->order_id);

        return response()->json(['success' => true], 200);
    }

    public function getByOrderID($order_id)
    {
        $detail =  OrderDetail::getByOrderIDAll($order_id);
        $payment =  OrderPayment::getDataByOrderIDUseOnly($order_id);
        return response()->json([
            'data' => $detail,
            'sum' => [
                'total' => number_format($detail->sum('sum_price'), 2),
                'deposit' => number_format($payment->sum('amount'), 2),
                'balance' => number_format($detail->sum('sum_price') - $payment->sum('amount'), 2),

            ]
        ], 200);
    }

    public function sentLinkForUploadImage(OrderDetail $detail)
    {
        // ตรวจสอบ มีสถานะสำหรับอัปโหลดรูปภาพ
        if ($detail->upload_image_status) {

            // เช็ค มีการสร้างไปหรือยัง หากมีให้ไปที่อัปเดทแทน
            $sent = SentLinkForUploadImage::find($detail->id);
            $input = request()->all();
            if ($sent) {
                $sent->update($input);
            } else {
                $input['order_detail_id'] = $detail->id;
                $input['token'] = Helper::generateToken();
                $sent = SentLinkForUploadImage::create($input);
            }

            // สร้างลิงก์
            $url = URL::punpang() . $sent->token . '/uploadImage';
            $bitly = Bitly::getUrl($url);

            $messgae = "โปรดคลิกลิงก์ เพื่ออัปโหลดรูปภาพ " . $bitly;
            MSms::SMSFB($detail->order, $messgae);
            Linenotify::send('ส่งลิงก์อัปโหลดรูปภาพ #' . $detail->order->id);

            return response()->json([
                'success' => true,
                'message' => "ส่งลิงก์สำหรับอัปโหลดสำเร็จ"
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "ไม่มีสิทธิ์ในการส่งลิงก์ สำหรับอัปโหลดรูปภาพ"
            ], 200);
        }
    }

    public function uploadImageByToken($token)
    {
        $sent = SentLinkForUploadImage::whereToken($token)->with('ExampleImage', 'Image')->first();
        if ($sent) {
            if ($sent->orderDetail->upload_image_status) {
                return response()->json([
                    'data' => $sent,
                    'success' => true,
                ], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
        }
    }

    public function uploadImageByTokenExample($token)
    {
        $sent = SentLinkForUploadImage::whereToken($token)->first();
        if ($sent) {
            if ($sent->orderDetail->upload_image_status) {
                Cloudder::upload(request()->file('image'));
                $cloudder = Cloudder::getResult();
                $image = new Image;
                $image->order_detail_id = $sent->order_detail_id;
                $image->public_id = $cloudder['public_id'];
                $image->url = $cloudder['url'];
                $image->type = 'example';
                $image->save();
                return response()->json(['success' => true, 'message' => "อัปโหลดรูปภาพสำเร็จ"], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
        }
    }

    public function uploadImageByTokenImages($token)
    {
        $sent = SentLinkForUploadImage::whereToken($token)->first();
        if ($sent) {
            if ($sent->orderDetail->upload_image_status) {
                Cloudder::upload(request()->file('image'));
                $cloudder = Cloudder::getResult();
                $image = new Image;
                $image->order_detail_id = $sent->order_detail_id;
                $image->public_id = $cloudder['public_id'];
                $image->url = $cloudder['url'];
                $image->type = 'images';
                $image->save();
                
                /*
                foreach (request()->file() as $file) {
                    Cloudder::upload($file);
                    $image = new Image;
                    $image->order_detail_id = $sent->order_detail_id;
                    $image->public_id = $cloudder['public_id'];
                    $image->url = $cloudder['url'];
                    $image->type = 'images';
                    $image->save();
                }
                */

                return response()->json(['success' => true, 'message' => "อัปโหลดรูปภาพสำเร็จ"], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
        }
    }

    public function uploadImageByTokenDelete($token, Image $image)
    {
        $sent = SentLinkForUploadImage::whereToken($token)->first();
        if ($sent) {
            if ($sent->orderDetail->upload_image_status) {
                Cloudder::delete($image->public_id);
                $image->delete();
                return response()->json(['success' => true, 'message' => "ลบรูปภาพสำเร็จ"], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
        }
    }

    public function updateWriteByToken($token)
    {
        $sent = SentLinkForUploadImage::whereToken($token)->first();
        if ($sent) {
            if ($sent->orderDetail->upload_image_status) {
                $sent->orderDetail->write_status = true;
                $sent->orderDetail->write = request('write');
                $sent->orderDetail->update();

                return response()->json(['success' => true, 'message' => "เปลี่ยนแปลงข้อความสำเร็จ"], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึงหน้าเว็ปได้'], 200);
        }
    }
}
