<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AOrder extends Model
{
  protected $table = 'a_order';

  protected $connection = 'order';

  // public $timestamps = false;

  public function scopeOrderTodayAll()
  {
    return $query = $this->whereDate('date_get',\Carbon\Carbon::now()->format('Y-m-d'))
    ->whereIn('status',[1,2,3,4,5,6,7,37]);
  }

  public function scopeOrderTodayConfirm()
  {
    return $query = $this->whereDate('date_get',\Carbon\Carbon::now()->format('Y-m-d'))
    ->whereIn('status',[3,4,5,6,7]);
  }

  public function scopeOrderTodayPreparedProduct() //สินค้าเตรียมพร้อม
  {
    return $query = $this->whereDate('date_get',\Carbon\Carbon::now()->format('Y-m-d'))
    ->where('status',8);
  }

  public function scopeOrderTodayNotConfirm() //รอการชำระเงิน
  {
    return $query = $this->whereDate('date_get',\Carbon\Carbon::now()->format('Y-m-d'))
    ->where('status','<=','2');
  }

  public function customer()
  {
    return $this->belongsTo(ACustomer::class,'customer_id','id');
  }

  public function OrderStatus()
  {
    return $this->belongsTo(AStatus::class,'status','id');
  }

  public function TotalAll()
  {
    return $this->total + $this->add + $this->TotalOther();
  }

  public function TotalOther()
  {
    return 0;
  }

  public function Deposit()
  {
    return $this->hasMany('App\Order\Payment','order_id','id')->where('status','1')->sum('value');
  }

  public function Balance()
  {
    return $this->TotalAll() - $this->Deposit();
  }

  public function PaymentChannel()
  {
    return PaymentChannel::StatusUse()->pluck('name','id');
  }

  public function HistoryPayment()
  {
    return $this->hasMany(Payment::class,'order_id','id')->orderBy('created_at','DESC');
  }

  public function CreatedAtFormat()
  {
    return 'สั่งเมื่อ '.\Carbon\Carbon::parse($this->created_at)->addYears(543)->format("d-m-Y H:i:s").' น.';
  }

  public function DetailsFormat()
  {
    return  $this->FindM1->m1.','.
            $this->FindM2->m2.','.
            $this->FindM3->m3.','.
            $this->FindM4->m4;
  }

  public function DateTimeGetFormat()
  {
    $datetime = $this->date_get.' '.$this->time_get;
    return 'รับเมื่อ '.\Carbon\Carbon::parse($datetime)->addYears(543)->format("d-m-Y H:i").' น.';
  }

  public function DateTimeGetFormat2()
  {
    $datetime = $this->date_get.' '.$this->time_get;
    return \Carbon\Carbon::parse($datetime)->addYears(543)->format("d-m-Y H:i").' น.';
  }

  public function FindM1()
  {
    return $this->belongsTo(AM1::class,'m1','id');
  }

  public function FindM2()
  {
    return $this->belongsTo(AM2::class,'m2','id');
  }

  public function FindM3()
  {
    return $this->belongsTo(AM3::class,'m3','id');
  }

  public function FindM4()
  {
    return $this->belongsTo(AM4::class,'m4','id');
  }

  public static function TimeGet()
  {
    $times = [
      ['data' => '08:30:00' , 'show' => '08:30'],
      ['data' => '09:00:00' , 'show' => '09:00'],
      ['data' => '09:30:00' , 'show' => '09:30'],
      ['data' => '10:00:00' , 'show' => '10:00'],
      ['data' => '10:30:00' , 'show' => '10:30'],
      ['data' => '11:00:00' , 'show' => '11:00'],
      ['data' => '11:30:00' , 'show' => '11:30'],
      ['data' => '12:00:00' , 'show' => '12:00'],
      ['data' => '12:30:00' , 'show' => '12:30'],
      ['data' => '13:00:00' , 'show' => '13:00'],
      ['data' => '13:30:00' , 'show' => '13:30'],
      ['data' => '14:00:00' , 'show' => '14:00'],
      ['data' => '14:30:00' , 'show' => '14:30'],
      ['data' => '15:00:00' , 'show' => '15:00'],
      ['data' => '15:30:00' , 'show' => '15:30'],
      ['data' => '16:00:00' , 'show' => '16:00'],
      ['data' => '16:30:00' , 'show' => '16:30'],
      ['data' => '17:00:00' , 'show' => '17:00'],
      ['data' => '17:30:00' , 'show' => '17:30'],
      ['data' => '18:00:00' , 'show' => '18:00'],
      ['data' => '18:30:00' , 'show' => '18:30'],
      ['data' => '19:00:00' , 'show' => '19:00'],
      ['data' => '19:30:00' , 'show' => '19:30'],
    ];
    return $times;
  }
}
