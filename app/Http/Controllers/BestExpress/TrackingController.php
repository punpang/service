<?php

namespace App\Http\Controllers\BestExpress;

use App\BestExpress\Tracking;
use App\BestExpress\Sender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\TrackingImport;
use Session , Excel;

class TrackingController extends Controller
{
    public function index()
    {
      $trackings = Tracking::orderBy('created_at','DESC')->get();
      return response()->json($trackings);
      return view('admin.bestexpress.tracking.index' , compact('trackings'));
    }


    public function create(Sender $sender)
    {
      return view('admin.bestexpress.tracking.create' , compact('sender'));
    }

    public function store()
    {
      request()->validate([
        'dates' => 'date',
        'sender_number' => 'numeric|digits:10',
        'recipient_number' => 'numeric|digits:10',
        'waybill' => 'numeric|digits:14|unique:best.trackings,waybill',
        'total' => 'numeric',
        'shipping_charge' => 'numeric|between:1,99999',
        'parcel_fee' => 'numeric',
        'other_values' => 'numeric',
        'besides' => 'numeric',
      ],[
        'waybill.digits' => 'กรอกเลขพัสดุ 14 หลัก',
        'waybill.unique' => 'เลขพัสดุนี้ มีในระบบแล้ว <a href="'.request('waybill').'">'.request('waybill').'</a>',
        'shipping_charge.between' => 'ค่าจัดส่ง : ต้องมากกว่า 1',
        'recipient_number.digits' => 'เบอร์ผู้รับ ต้องมี 10 หลัก'
      ]);

      $tracking = new Tracking;
      $tracking->sender_number = request('sender_number');
      $tracking->recipient_number = request('recipient_number');
      $tracking->waybill = request('waybill');
      $tracking->shipping_charge = request('shipping_charge');
      $tracking->parcel_fee = request('parcel_fee');
      $tracking->other_values = request('other_values');
      $tracking->besides = request('besides');
      $tracking->total = request('total');
      $tracking->dates = request('dates');
      $tracking->save();

      Session::flash('success','ลงทะเบียนเรียบร้อย WAYBILL : <a href="https://www.best-inc.co.th/track?bills='.$tracking->waybill.'">'.$tracking->waybill.'</a>');
      return back();
    }

    public function show($waybill)
    {
      $tracking = Tracking::where('waybill',$waybill)->firstOrFail();
      return view('admin.bestexpress.tracking.show',compact('tracking'));
    }

    public function edit($waybill)
    {
      $tracking = Tracking::where('waybill',$waybill)->firstOrFail();
      return view('admin.bestexpress.tracking.edit',compact('tracking'));
    }

    public function update(Tracking $id)
    {
      request()->validate([
        'dates' => 'date',
        'waybill' => 'numeric|digits:14|unique:best.trackings,waybill,'.$id->id,
        'total' => 'numeric',
        'shipping_charge' => 'numeric',
        'parcel_fee' => 'numeric',
        'other_values' => 'numeric',
        'besides' => 'numeric',
      ],[
        'waybill.digits' => 'กรอกเลขพัสดุ 14 หลัก',
        'waybill.unique' => 'เลขพัสดุนี้ มีในระบบแล้ว <a href="'.request('waybill').'">'.request('waybill').'</a>'
      ]);

      $id->waybill = request('waybill');
      $id->shipping_charge = request('shipping_charge');
      $id->parcel_fee = request('parcel_fee');
      $id->other_values = request('other_values');
      $id->besides = request('besides');
      $id->total = request('total');
      $id->dates = request('dates');
      $id->save();

      Session::flash('success','เปลี่ยนแปลงเสร็จสมบูรณ์');
      return redirect()->action('BestExpress\TrackingController@show', ['waybill' => $id->waybill]);
    }

    public function SenderFind()
    {
      return view('admin.bestexpress.tracking.SenderFind');
    }

    public function SenderChoose()
    {
      $senders = Sender::where('name','like',request('SenderFind').'%')->orWhere('tel',request('SenderFind'))->get();
      return view('admin.bestexpress.tracking.SenderFind',compact('senders'));
    }

    public function importExportView()
    {
       return view('admin.bestexpress.port.import');
    }

    public function export()
    {
        return Excel::download(new TrackingExport, 'users.xlsx');
    }

    public function import()
    {
        Excel::import(new TrackingImport,request()->file('file'));
        Session::flash('success','Imports Success');
        return back();
    }

    public function ShowTracking(Sender $sender , $date)
    {
      $trackings = Tracking::where([
        ['sender_number',$sender->tel],
        ['dates',$date]
      ])->orderBy('recipient_name','ASC')->get();

      return view('bestexpress.tracking.ShowTracking' , compact('trackings' , 'sender' , 'date'));
    }
}
