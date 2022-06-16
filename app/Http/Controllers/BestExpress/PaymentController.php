<?php

namespace App\Http\Controllers\BestExpress;

use App\BestExpress\Sender;
use App\BestExpress\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session ,URL;
use App\Linenotify;
use App\MSms;
use App\Shotlink;

class PaymentController extends Controller
{
    public function create(Sender $sender , $date)
    {
      // dd($sender , $date , request('total'));
      request()->validate([
        'total' => 'numeric'
      ]);

      $payment = new Payment;
      $payment->sender_id = $sender->id;
      $payment->date = $date;
      $payment->total = request('total');
      $payment->status = '1';
      $payment->save();

      Session::flash('success','แจ้งยอดชำระทั้งหมด ไปยังลูกค้าเรียบร้อย');

      $addMiutes = \Carbon\Carbon::now()->addDays(7);
      $url_sms = URL::temporarySignedRoute('signed.bestexpress.sender',$addMiutes,['sender' => $sender->id , 'date' => $date]);
      $shotlink = Shotlink::shorten($url_sms);

      $sms = 'Best Express DP.Pranburi พัสดุวันที่ '.$date.' ยอดชำระทั้งหมด '.number_format($payment->total,2).' บาท รายละเอียดเพิ่มเติม [ '.$shotlink.' ]';
      $line = 'แจ้งชำระเงิน -> คุณ '.$sender->name.' พัสดุวันที่ '.$date.' ยอดชำระทั้งหมด '.number_format($payment->total,2).' บาท' .$shotlink;

      MSms::Sms('0864735562',$sms);
      Linenotify::send($line);

      return back();

    }
}
