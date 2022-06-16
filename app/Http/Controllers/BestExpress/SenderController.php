<?php

namespace App\Http\Controllers\BestExpress;

use App\BestExpress\Sender;
use App\BestExpress\Tracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class SenderController extends Controller
{
    public function index()
    {
      $senders = Sender::get();
      return view('admin.bestexpress.sender.index' , compact('senders'));
    }

    public function create()
    {
      return view('admin.bestexpress.sender.create');
    }

    public function store()
    {
      request()->validate([
        'name' => 'required',
        'tel' => 'numeric|digits:10|unique:best.senders,tel',
        'address' => 'required'
      ],[
        'tel.numeric' => 'หมายเลขโทรศัพท์ : เฉพาะตัวเลขเท่านั้น',
        'tel.unique' => 'หมายเลขโทรศัพท์ : หมายเลขนี้ มีในระบบแล้ว',
        'tel.digits' => 'หมายเลขโทรศัพท์ : ตัวเลข 10 หลัก'
      ]);

      $sender = new Sender;
      $sender->name = request('name');
      $sender->tel = request('tel');
      $sender->address = request('address');
      $sender->save();

      return redirect()->action('BestExpress\SenderController@show',[ 'sender' => $sender->id ]);
    }

    public function show(Sender $sender)
    {
      return view('admin.bestexpress.sender.show' , compact('sender'));
    }

    public function edit(Sender $sender)
    {
      return view('admin.bestexpress.sender.edit' , compact('sender'));
    }

    public function update(Sender $sender)
    {
      request()->validate([
        'name' => 'required',
        'tel' => 'numeric|digits:10|unique:best.senders,tel,'.$sender->id,
        'address' => 'required'
      ],[
        'tel.numeric' => 'หมายเลขโทรศัพท์ : เฉพาะตัวเลขเท่านั้น',
        'tel.unique' => 'หมายเลขโทรศัพท์ : หมายเลขนี้ มีในระบบแล้ว',
        'tel.digits' => 'หมายเลขโทรศัพท์ : ตัวเลข 10 หลัก'
      ]);

      $sender->name = request('name');
      $sender->tel = request('tel');
      $sender->address = request('address');
      $sender->update();

      Session::flash('success','แก้ไขข้อมูลเรียบร้อย');

      return redirect()->action('BestExpress\SenderController@show' , [ 'sender' => $sender->id ]);
    }

    public function ShowTrackingGet(Sender $sender , $date)
    {
      $trackings = Tracking::where([
        ['sender_number',$sender->tel],
        ['dates',$date]
      ])->get();

      if ($trackings->count() > 0) {
        // Session::flash('success','มีพัสดุจำนวน '.$trackings->count().' ชิ้น');
        return view('admin.bestexpress.sender.ShowTracking' , compact('sender' , 'trackings' ,'date'));
      }else {
        Session::flash('warning','ไม่มีข้อมูลพัสดุของวันที่ '.\Carbon\Carbon::parse($date)->addYears(543)->format('d-m-Y'));
        return back();
      }
    }

    public function ShowTrackingPost(Sender $sender)
    {
      return redirect()->action('BestExpress\SenderController@ShowTrackingGet' , ['sender' => $sender->id , 'date' => request('dates')]);
    }


}
