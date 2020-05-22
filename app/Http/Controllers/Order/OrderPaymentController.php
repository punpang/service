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
use App\Order\SilpUnVerifyReasoning;
use phpDocumentor\Reflection\Types\Boolean;

class OrderPaymentController extends Controller
{
    public function create()
    {
        try {
            // จัดรูปแบบก่อนสร้าง
            $input = OrderPayment::FormatData(request()->all());

            //ตรวจสอบสลิปซ้ำ
            if (isset($input['slip_ref'])) {
                $check_slip = Slip::whereRef($input['slip_ref'])->first();
                if ($check_slip) {
                    if ($check_slip->slip_verify_id != 4) {
                        return response()->json([
                            'data' => $check_slip,
                            'success' => false,
                            'message' => 'รหัสอ้างอิงซ้ำ'
                        ], 299);
                    }
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
            if (Member::beMember($order->customer->phone)) {
                $addScore = $sale->total_money / Config_software::Score()->score;
                Summary_score_of_member::addScore($sale->member_id, $addScore);
            }

            // สร้างการชำระเงิน
            $data = OrderPayment::create($input);

            // มี ref
            if ($data->slip_id) {
                $data->slip->ref = $input['slip_ref'];
                $data->slip->slip_verify_id = 2;
                $data->slip->update();
                /*
                $ocr = GoogleOcr::where('ocr_text', $input['slip_ref'])->first();
                if ($ocr) {
                    $ocr->delete();
                }
                */
            }

            // สถานะ ไม่ชำระ
            $oldOrderStatusID = $data->order->order_status_id;

            // เปลี่ยนสถานะเป็นชำระ กรณีที่ต่ำกว่า 4
            if ($data->order->order_status_id <= 5) {
                $data->order->order_status_id = 4;
                $data->order->update();
            }

            //เมื่อชำระผ่านธนาคาร


            // แจ้งเตือน
            if ($data->order->balance() > 0) {
                $messgae = "รายการสั่งซื้อ #" . $data->order->id . " ขอบคุณที่ชำระเงิน " . $data->amountFormat() . "บ. ท่านสามารถชำระยอดคงเหลือ " . $data->order->balanceFormat() . "บ. พร้อมกับรับสินค้าได้เลยค่ะ";
            } else {
                if ($data->order->order_status_id == 6 || $oldOrderStatusID == 5) { //เตรียมสินค้าแล้ว
                    $messgae = "รายการสั่งซื้อ #" . $data->order->id . " ขอบคุณที่ชำระเงิน " . $data->amountFormat() . "บ. ท่านชำระเงินครบจำนวนแล้ว";
                } else {
                    $messgae = "รายการสั่งซื้อ #" . $data->order->id . " ขอบคุณที่ชำระเงิน " . $data->amountFormat() . "บ. ท่านชำระเงินครบจำนวนแล้ว สามารถรับสินค้าตามเวลานัดรับได้เลยค่ะ";
                }
            }

            MSms::SMSFB($order, $messgae, $input['alert']);
            Linenotify::send('รายการสั่งซื้อ #' . $data->order->id . ' => ยืนยันการสั่งซื้อแล้ว');

            return response()->json([
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

            //ปรับสถานะ silp เป็น รอการตรวจสอบอีกครั้ง
            if ($payment->slip_id) {
                $payment->slip->slip_verify_id = 4;
                $payment->slip->update();
            }

            // เปลี่ยนสถานะเป็นยกเลิก
            $payment->status = '0';
            $payment->update();

            //ค้นหาบิลที่สอดคล้อง และเปลี่ยนสถานะเป็น DELETE
            $payment->Bill_ID->status = 'delete';
            $payment->Bill_ID->save();

            // หากเป็นสมาชิกให้ลดคะแนน
            if (Member::beMember($payment->order->customer->phone)) {
                $addScore = $payment->Bill_ID->total_money * (-1) / Config_software::Score()->score;
                Summary_score_of_member::addScore($payment->Bill_ID->member_id, $addScore);
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

            $messgae = "รายการสั่งซื้อ #" . $order->id . ' โปรดชำระมัดจำขั้นต่ำด้วยยอด ' . number_format($input['amount'], 2) . ' บ. ช่องทางการชำระเงินและแจ้งการชำระเงินที่ได้ ' . $bitly;

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

            $messgae = 'ขอบคุณที่ชำระเงิน รายการสั่งซื้อ #' . $order->id . ' เราจะตรวจสอบและแจ้งผลโดยเร็วที่สุดค่ะ';
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

    public function unVerifySlip(Slip $slip)
    {
        // เปลี่ยนสถานะ slip  เป็นไม่ผ่านการตรวจสอบ
        // และเพิ่มเหตุผลการยกเลิก
        $slip->slip_verify_id = 3;
        $slip->slip_un_verify_reasoning_id = request('slip_un_verify_reasoning_id');
        $slip->update();
        //
        $messgae = 'การชำระเงินของคุณ รายการสั่งซื้อ #'.$slip->order->id.' ไม่ผ่านการตรวจสอบ เนื่องจาก : ' . $slip->silpUnVerifyReasoning->reasoning . ' รบกวนแจ้งชำระใหม่อีกครั้ง ผ่านลิงก์ก่อนหน้านี้ค่ะ';
        MSms::SMSFB($slip->order, $messgae, true);
        Linenotify::send('ไม่ผ่านการชำระ #' . $slip->order->id);

        return response()->json([
            'success' => true
        ], 200);
    }

    public function unVerifyReasoning()
    {
        $data = SilpUnVerifyReasoning::useOnly()->get();
        return $data;
    }

    public function notPayDeposit()
    {
        request()->validate([
            'order_id' => 'required',
            'alertSMS' => 'required|boolean'
        ]);

        $input = request()->all();
        $data = Order::whereId($input['order_id'])->whereIn('order_status_id', [2, 3])->first();
        if ($data) {
            $data->order_status_id = 5;
            $data->update();

            $messgae = "รายการสั่งซื้อ #" . $data->id . ' ลูกค้ายืนยันไม่สะดวกชำระมัดจำ ทางร้านขอนัดลูกค้าเข้าร้าน คิว ' . \Carbon\Carbon::parse($data->dateTime_get)->addYears(543)->format('d-m-Y H:i') . " เพื่อรอตกแต่งสินค้า 15-30 นาทีค่ะ";
            MSms::SMSFB($data, $messgae, $input['alertSMS']);
            Linenotify::send('ไม่ผ่านการชำระ #' . $data->id);

            return response()->json([
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => "รายการสั่งซื้อนี้ ไม่ได้อยู่ในสถานะที่สามารถเปลี่ยนสถานะเป็น 'ไม่ชำระมัด' จำได้"
            ], 200);
        }
    }
}
