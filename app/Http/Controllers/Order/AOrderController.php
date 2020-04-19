<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\AOrder;
use App\Order\ACustomer;
use App\Order\AM1;
use App\Order\AM2;
use App\Order\AM3;
use App\Order\AM4;
use App\Order\APrice;
use App\Linenotify;
use App\MSms;
use Session;

class AOrderController extends Controller
{
    public function DashboardToday()
    {
      //$orders = AOrder::OrderTodayConfirm()->orderBy('time_get','ASC')->get();
      $orders = AOrder::take(100)->orderBy('time_get','ASC')->get();
      return response()->json($orders, 200);
      return view('admin/order/dashboard/today',compact('orders'));
    }

    public function ShowOrder(AOrder $order)
    {
      if ($order->status == '0') {
        Session::flash('warning','รายการสั่งซื้อนี้ ยังไม่ได้ <a href="#" class="alert-link" data-toggle="modal" aria-label="Close" data-target="#modal_alert_to_customer">แจ้งเตือน</a> การชำระเงินแก่ลูกค้า');
      }
      elseif ($order->status == '1'){
        Session::flash('warning','รายการสั่งซื้อนี้ ยังไม่ได้รับการยืนยันการสั่งซื้อ <a href="#" class="alert-link" data-toggle="modal" aria-label="Close" data-target="#modal_alert_to_customer">แจ้งเตือนอีกครั้ง</a>');
      }

      return view('admin.order.order.ShowOrder',compact('order'));
    }

    public function NewOrder()
    {
        $customer = ACustomer::where('tel',request('phone'))->first();
        $times = AOrder::TimeGet();
        $m1 = AM1::DataUsePluck();
        $m2 = AM2::All()->pluck('m2','id');
        $m3 = AM3::All()->pluck('m3','id');
        $m4 = AM4::DataUsePluck();

        return view('admin.order.order.NewOrder',compact('customer','times','m1','m2','m3','m4'));
    }

    public function Step2($phone)
    {
      $date = \Carbon\Carbon::now()->format('Y-m-d');
      $time = \Carbon\Carbon::now()->format('H:i:s');

      if (request('date_get') < $date) {
        Session::flash('danger','วันที่รับไม่ถูกต้อง');
        return back()->withInput();
      }elseif (request('date_get') == $date) {
        if (request('time_get') < $time) {
          Session::flash('danger','เวลารับไม่ถูกต้อง');
          return back()->withInput();
        }
      }

      // dd($time,request('time_get'));
      // request()->validate([
      //   'm1' => 'required|numeric',
      //   'm2' => 'required|numeric',
      //   'm3' => 'required|numeric',
      //   'm4' => 'required|numeric',
      //   'code' => 'required',
      //   'msg' => 'required',
      //   'other' => 'required',
      // ]
      // ,[
      //   'date_get.after' => 'วันที่สั่งซื้อไม่ถูกต้อง',
      //   'date_get.date' => 'วันที่สั่งซื้อไม่ถูกต้อง date',
      //   'phone.digits' => 'โปรดกรอกหมายเลขโทรศัพท์ 10 หลัก',
      //   'phone.regex' => 'โปรดกรอกขึ้นต้นด้วยเลข 0 เท่านั้น',
      //   'phone.numeric' => 'โปรดกรอกเป็นตัวเลขเท่านั้น',
      // ]
      // );


      $code = request('m1').request('m2').request('m3').request('m4');
      $price = APrice::where('code',$code)->first();
      if ($price == null) {
        Session::flash('danger','กรุณาเลือกให้สัมพันธ์กัน');
        return back()->withInput();
      }
      $customer = ACustomer::where('tel',$phone)->first();

      $data = [
        'date_get' => request('date_get'),
        'time_get' => request('time_get'),
        'm1' => AM1::FindData(request('m1')),
        'm2' => AM2::FindData(request('m2')),
        'm3' => AM3::FindData(request('m3')),
        'm4' => AM4::FindData(request('m4')),
        'code' => request('code'),
        'msg' => request('msg'),
        'other' => request('other'),
      ];

      return view('admin.order.order.Step2',compact('data','price','customer'));
    }

    public function createOrder($phone)
    {
      // dd(request()->all());

      $customer = ACustomer::where('tel',$phone)->first();

      
      $order = new AOrder;
      $order->customer_id = $customer->id;
      $order->date_get = request('date_get');
      $order->time_get = request('time_get');
      $order->m1 = request('m1');
      $order->m2 = request('m2');
      $order->m3 = request('m3');
      $order->m4 = request('m4');
      $order->code = request('code');
      $order->msg = request('msg');
      $order->other = request('other');
      $order->total_all = "0";
      $order->total = request('total');
      $order->add = request('add');
      $order->deposit = "0";
      $order->balance = request('total');
      $order->status = "1";
      $order->ways = "0";
      $order->date_order = \Carbon\Carbon::now();
      $order->billno = "0";
      $order->auth_order = "";
      $order->save();

      $message = 'สร้างรายการใหม่ #'.$order->id.' เมื่อ '.$order->date_order.' '.url('admin/order',[$order->id]);
      Linenotify::send($message);

      Session::flash('success','สร้างรายการใหม่เรียบร้อย');
      return redirect()->action('Order\AOrderController@ShowOrder',[$order->id]);
    }

    public function AlertToCustomer(AOrder $order)
    {
      $order->status = "1";
      $order->save();

      MSms::Sms($order->customer->tel,'รายการสั่งซื้อ #'.$order->id. ' ของคุณ เรากำลังรอยืนยันการสั่งซื้อจากคุณ ยอดชำระทั้งหมด '.number_format($order->total,2).' บ. โปรดชำระขั้นต่ำ '.number_format($order->total/2,2).' บ. \n\nชำระโอนผ่านธนาคาร 408-672-0266 (พรรษิษฐ์ ศรีสุข) ธนาคารไทยพาณิชย์ แจ้งชำระเงินได้ที่ ...');
      Linenotify::send('รายการสั่งซื้อ #'.$order->id.' => แจ้งเตือนการชำระเงินไปยังลูกค้า');

      Session::flash('success','แจ้งรายละเอียดการชำระเรียบร้อย');

      return back();
    }
}
