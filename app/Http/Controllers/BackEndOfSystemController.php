<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tb_bill_sale;
use App\Tb_coupon_detail;
use App\Linenotify;
use App\MSms;
use App\Config_software;
use App\AOrder;
use App\Shotlink;
use URL;
class BackEndOfSystemController extends Controller
{
    public function last_sell()
    {
      $bills = Tb_bill_sale::LastSellOfDay()->where([
        ['bill_alert','0'],
        ['status','normal']
        ])->take(5)
        ->get();

        foreach ($bills as $bill) {
          if ($bill->coupon_detail_id != 0) {
            $coupon = Tb_coupon_detail::where('serial',$bill->coupon_detail_id)->first();
            $coupon->use = $bill->bill_sale_created_date;
            $coupon->status = 'use';
            $coupon->save();
          }
          if ($bill->member_id != 0) {
            MSms::Sms($bill->member->member_tel,'ปั้นแป้ง สวัสดีค่ะ คุณได้ซื้อสินค้ากับเรา บิล.'.$bill->bill_sale_id.' ยอดซื้อ '.number_format($bill->total_money,2).' บ. ได้รับคะแนน '.($bill->total_money/Config_software::Score()->score).' คะแนน คะแนนทั้งหมด '.number_format($bill->member->PointCoupon->score_total,2).' คะแนน');
          }
          $billSave = Tb_bill_sale::where('bill_sale_id',$bill->bill_sale_id)->first();
          $bill->bill_alert = '1';
          $bill->save();

          $message = 'บิลที่ '.$bill->bill_sale_id.' ยอดขาย '.number_format($bill->total_money,2).'บ. เมื่อ '.\Carbon\Carbon::parse($bill->bill_sale_created_date)->addYears(543)->format('d/m/Y H:i:s');
          Linenotify::send($message);
        }
    }

    public function LastSellCancel()
    {
      $bills = Tb_bill_sale::LastSellOfDay()
        ->whereIn('bill_alert',['0','1'])
        ->where('status','delete')
        ->take(5)
        ->get();

        foreach ($bills as $bill) {
          if ($bill->member_id != 0) {
            MSms::Sms($bill->member->member_tel,'ปั้นแป้ง สวัสดีค่ะ บิล.'.$bill->bill_sale_id.' ของคุณถูกยกเลิก ด้วยยอด '.number_format($bill->total_money,2).' บ. ยกเลิกคะแนน '.($bill->total_money/Config_software::Score()->score).' คะแนน คะแนนคงเหลือ '.number_format($bill->member->PointCoupon->score_total,2).' คะแนน *หากไม่ถูกต้อง โปรดติดต่อกลับ 091-885-3402');
          }

          // if ($bill->coupon_detail_id != 0) {
          //   $coupon = Tb_coupon_detail::where('serial',$bill->coupon_detail_id)->first();
          //   $coupon->use = null;
          //   $coupon->status = 'unuse';
          //   $coupon->save();
          //   MSms::Sms($bill->member->member_tel,'ปั้นแป้ง สวัสดีค่ะ บิล.'.$bill->bill_sale_id.' ของคุณถูกยกเลิก ด้วยยอด '.number_format($bill->total_money,2).' บ. ยกเลิกคะแนน '.($bill->total_money/Config_software::Score()->score).' คะแนน คะแนนคงเหลือ '.number_format($bill->member->PointCoupon->score_total,2).' คะแนน *หากไม่ถูกต้อง โปรดติดต่อกลับ 091-885-3402');
          // }

          $billSave = Tb_bill_sale::where('bill_sale_id',$bill->bill_sale_id)->first();
          $bill->bill_alert = '2';
          $bill->save();

          $message = 'บิลที '.$bill->bill_sale_id.' ถูกยกเลิก ด้วยยอด '.number_format($bill->total_money,2).'บ.';
          Linenotify::send($message);
        }
    }

    public function OrderTodayCount()
    {
      $url = URL::temporarySignedRoute('signed.backend.dashboard.today',\Carbon\Carbon::now()->addHours(12));
      $shotlink = Shotlink::shorten($url);
      $m = 'วันนี้มีรายการสั่งซื้อล่วงหน้า จำนวน '.AOrder::OrderTodayAll()->count().' รายการ '.$shotlink;
      Linenotify::send($m);
    }

    public function SumOfDay()
    {
      $SumOfDay = Tb_bill_sale::LastSellOfDay()
        ->where('status','normal')
        ->get();
      // dd($SumOfDay->sum('bonus_price'));
      $m = 'วันที่ '.\Carbon\Carbon::now()->addYears(543)->format('d/m/Y').' ยอดทั้งหมด '.number_format($SumOfDay->sum('total_money'),2).' บ. ยอดส่วนลด '.number_format($SumOfDay->sum('bonus_price'),2).' บ. ยอดสุทธิ '.number_format(($SumOfDay->sum('total_money') - $SumOfDay->sum('bonus_price')),2).' บ.';
      MSms::Sms('0892549833',$m);
      Linenotify::send($m);
    }
}
