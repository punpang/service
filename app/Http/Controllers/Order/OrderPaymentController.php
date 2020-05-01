<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderPayment;
use App\Order\Order;
use App\Member;
use App\Tb_bill_sale;
use App\Config_software;
use App\GoogleImage;
use App\Summary_score_of_member;
use App\Linenotify;
use App\MSms;
use App\URL;
use App\Order\Slip;
use Bitly;
use App\GoogleOcr;

class OrderPaymentController extends Controller
{
    public function create()
    {
        try {
            // จัดรูปแบบก่อนสร้าง
            $input = OrderPayment::FormatData(request()->all());

            //ตรวจสอบสลิปซ้ำ
            if ($input['slip_ref']) {
                $check_slip = Slip::whereRef($input['slip_ref'])->first();
                if ($check_slip) {
                    // เปลี่ยนสถานะเป็นไม่ผ่าน
                    $slip = Slip::find($input['slip_id']);
                    $slip->slip_verify_id = 3;
                    $slip->update();

                    return response()->json([
                        'success' => false,
                        'message' => 'อ้างอิงซ้ำ'
                    ], 299);
                }
            }

            //ค้นหารายการสั่งซื้อ
            $order = Order::find($input['order_id']);

            // ตรวจสอบ ว่าชำระครบจำนวนหรือยัง
            if ($order->balance() <= 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'ชำระครบจำนวนแล้ว'
                ], 200);
            }

            // หาจำนวนเงิน
            if ($input['amount'] > $order->balance()) {
                $input_money = $input['amount'];
                $return_money = $input['amount'] - $order->balance();
                $total_money = $order->balance();
                $input['amount'] = $order->balance();
            } else {
                $input_money = $input['amount'];
                $return_money = '0';
                $total_money = $input['amount'];
            }

            // สร้างบิลใน store
            $sale = new Tb_bill_sale;
            $sale->bill_sale_created_date = \Carbon\Carbon::now();
            $sale->bill_sale_status = 'pay';
            $sale->member_id = Member::beMember($order->customer->phone);
            $sale->user_id = '2';
            $sale->input_money = $input_money;
            $sale->return_money = $return_money;
            $sale->total_money = $total_money;
            $sale->created_Bill_sale = $sale->bill_sale_created_date;
            $sale->save();

            // เพิ่มตัวแปล bill_id
            $input['bill_id'] = $sale->bill_sale_id;

            // หากเป็นสมาชิกให้เพิ่มคะแนน
            if (Member::beMember($order->customer->tel) != null) {
                $addScore = $sale->total_money / Config_software::Score()->score;
                Summary_score_of_member::addScore($sale->member_id, $addScore);
            }

            // สร้างการชำระเงิน
            $data = OrderPayment::create($input);

            // มี ref
            if ($data->slip_id) {
                $slip = Slip::find($data->slip_id);
                $slip->ref = $input['slip_ref'];
                $slip->slip_verify_id = 2;
                $slip->update();

                $ocr = GoogleOcr::where('ocr_text', $input['slip_ref'])->first();
                $ocr->delete();
            }

            // เปลี่ยนสถานะเป็นชำระ กรณีที่ต่ำกว่า 4
            $order = Order::find($data->order_id);
            if ($order->order_status_id <= 4) {
                $order->order_status_id = 4;
                $order->update();
            }

            //เมื่อชำระผ่านธนาคาร


            // แจ้งเตือน
            //$messgae = 'ทดสอบ ชำระเงิน SMS FACEBOOK';
            //MSms::SMSFB($order, $messgae, $input['alert']);
            Linenotify::send('รายการสั่งซื้อ #' . $order->id . ' => ยืนยันการสั่งซื้อแล้ว');

            return response()->json([
                $data,
                'success' => true,
                'message' => 'รับชำระเงินสำเร็จ'
            ], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function cancel(OrderPayment $payment)
    {
        try {
            // ตรวจสอบว่าถูกยกเลิกไปแล้วหรือยัง
            if ($payment->status == 0) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'รายการชำระนี้ ถูกยกเลิกไปแล้ว'
                    ],
                    201
                );
            }

            // เปลี่ยนสถานะเป็นยกเลิก
            $payment->status = '0';
            $payment->update();

            //คนหาบิลที่สอดคล้อง และเปลี่ยนสถานะเป็น DELETE
            $sale = Tb_bill_sale::find($payment->bill_id);
            $sale->status = 'delete';
            $sale->save();

            // หากเป็นสมาชิกให้ลดคะแนน
            if (Member::beMember($payment->order->customer->phone) != null) {
                $addScore = $sale->total_money * (-1) / Config_software::Score()->score;
                Summary_score_of_member::addScore($sale->member_id, $addScore);
            }

            // ตรวจสอบว่า มีรายการชำระอื่นไหม หากไม่มีให้เปลี่ยนสถานะออร์เดอร์เป็น เพิ่มสินค้า
            if ($payment->order->sumDeposit() <= 0) {
                $payment->order->order_status_id = 2;
                $payment->order->update();
            }

            $messgae = 'ทดสอบ ชำระเงิน SMS FACEBOOK';
            //MSms::SMSFB($order, $messgae, $input['alert']);
            Linenotify::send('ยกเลิกรายการชำระเงิน');

            return response()->json([
                'success' => true,
                'message' => 'ยกเลิกรายการชำระเงิน #' . $payment->order_id
            ], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function alert()
    {
        try {
            // เปลี่ยนตัวแปร
            $input = request()->all();

            // ค้นหา order
            $order = Order::find($input['order_id']);

            $url = URL::punpang() . $order->token . '/' . $input['amount'] . '/payment';
            $bitly = Bitly::getUrl($url); // http://bit.ly/nHcn3

            $messgae = '#ปั้นแป้ง# Order.#' . $order->id . ' โปรดชำระมัดจำขั้นต่ำด้วยยอด ' . number_format($input['amount'], 2) . ' บ. ช่องทางการชำระเงินและแจ้งการชำระเงินที่ได้ ' . $bitly;

            //$messgae = '#ปั้นแป้ง# Order.#'.$order->id.' ยอดชำระทั้งหมด '.$order->sumTotalFormat().' บ. ชำระแล้ว '.$order->sumDepositFormat().' บ. คงเหลือ '.$order->sumBalanceFormat().' บ. โปรดชำระเงินขั้นต่ำด้วยยอด '.number_format($input['amount'],2).' บ. รายละเอียดการชำระเงินและแจ้งขำระเงินได้ที่ ';
            MSms::SMSFB($order, $messgae, true);
            Linenotify::send('แจ้งชำระเงิน #' . $order->id);

            return response()->json([
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function uploadslip($token)
    {
        try {
            // ค้นหาออร์เดอร์ด้วย token
            $order = Order::whereToken($token)->first();

            // ตรวจสอบว่ามีอยู่จริงไหม หากไม่ ให้ตอบกลับ
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่สามารถเข้าถึงได้'
                ], 590);
            }

            //อัปโหลดรูป และรับ pathid
            $imagePath = GoogleImage::StoreAndFindPath(request('image'));
            GoogleOcr::ocrImage(request('image'), $imagePath);

            $input['order_id'] = $order->id;
            $input['path'] = $imagePath;

            // สร้างสลิป
            Slip::create($input);

            $messgae = 'ขอบคุณที่ชำระเงิน เราจะตรวจสอบและแจ้งผลโดยเร็วที่สุดค่ะ';
            MSms::SMSFB($order, $messgae, true);
            Linenotify::send('แจ้งชำระเงิน #' . $order->id);

            return response()->json([
                'success' => true,
                'message' => 'แจ้งชำระเงินสร็จสิ้น'
            ], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function checkRef()
    {
        dd(request()->all());
        /*
        try {
        } catch (\Exception $e) {
            return $e;
        }
        */
    }
}
