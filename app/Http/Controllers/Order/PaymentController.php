<?php

namespace App\Http\Controllers\Order;

use App\Order\Payment;
use App\Order\AOrder;
use App\Store\Tb_bill_sale_detail;
use App\Member;
use App\Tb_bill_sale;
use App\Config_software;
use App\Summary_score_of_member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth ,Session;
use App\Linenotify;
use App\MSms;

class PaymentController extends Controller
{
    public function store(AOrder $order)
    {
      // return back()->withInput();
      // dd(Member::beMember($order->customer->tel));
      if ($order->Balance() <= 0) {
        Session::flash('warning','ไม่สามารถชำระเงินได้ เนื่องจากชำระเต็มจำนวนแล้ว');
        return back();
      }

      if (request('value') > $order->Balance()) {
        $input_money = request('value');
        $return_money = request('value') - $order->Balance();
        $total_money = $order->Balance();
      }else {
        $input_money = request('value');
        $return_money = '0';
        $total_money = request('value');
      }

      $sale = new Tb_bill_sale;
      $sale->bill_sale_created_date = \Carbon\Carbon::now();
      $sale->bill_sale_status = 'pay';
      $sale->member_id = Member::beMember($order->customer->tel);
      $sale->user_id = '2';
      $sale->input_money = $input_money;
      $sale->return_money = $return_money;
      $sale->total_money = $total_money;
      $sale->created_Bill_sale = $sale->bill_sale_created_date;
      $sale->save();

      if (Member::beMember($order->customer->tel) != null) {
        $addScore = $sale->total_money/Config_software::Score()->score;
        Summary_score_of_member::addScore($sale->member_id,$addScore);
      }

      // $detail = new Tb_bill_sale_detail;
      // $detail->bill_id = $sale->bill_sale_id;
      // $detail->bill_sale_detail_barcode = '111898';
      // $detail->bill_sale_detail_price = request('value');
      // $detail->bill_sale_detail_total = request('value');
      // $detail->bill_sale_detail_qty = '1';
      // $detail->bill_sale_detail_price_vat = '0';
      // $detail->status = 'use';
      // $detail->save();

      $pay = new Payment;
      $pay->order_id = $order->id;
      $pay->user_id = Auth::id();
      $pay->payment_channel_id  = request('payment_channel');
      $pay->value = $total_money;
      $pay->bill_id = $sale->bill_sale_id;
      $pay->save();

      MSms::Sms($order->customer->tel,'ขอบคุณที่ชำระเงินค่ะ '.number_format($total_money,2).' บ. สำหรับรายการสั่งซื้อ #'.$order->id. ' รายละเอียดคลิก ...');
      Linenotify::send('รายการสั่งซื้อ #'.$order->id.' => ยืนยันการสั่งซื้อแล้ว');

      Session::flash('success','ชำระเงินสำเร็จ '.number_format($total_money,2).' บ.');
      return redirect()->action('Order\AOrderController@ShowOrder' , [$order->id]);
    }

    public function cancel(Aorder $order)
    {
      $paymented = Payment::find(request('cancel_bill_id'));
      
      if ($order->id != $paymented->order_id) {
        Session::flash('danger','ไม่สามารถยกเลิกการชำระเงินได้ เนื่องจากการทำรายการบางอย่างไม่ถูกต้อง');
        return back();
      }

      $paymented->status = '0';
      $paymented->save();

      $saled = Tb_bill_sale::find($paymented->bill_id);
      $saled->status = 'delete';
      $saled->save();

      MSms::Sms($order->customer->tel,'รายการสั่งซื้อ #'.$order->id. ' ของคุณ ถูกยกเลิกการชำระเงิน เลขที่ใบเสร็จ '.$paymented->bill_id.' หากไม่ถูกต้องโปรดแจ้ง 091-885-3402');
      Linenotify::send('รายการสั่งซื้อ #'.$order->id.' => ยกเลิกการชำระเงิน => เลขที่ '.$paymented->id);

      Session::flash('success','ยกเลิกการชำระเงิน เลขที่ '.$paymented->id.' เสร็จสิ้น');

      return back();
    }
}
