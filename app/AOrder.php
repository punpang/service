<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AOrder extends Model
{
  protected $table = 'a_order';

  protected $connection = 'order';

  public $timestamps = false;

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
    return $this->belongsTo(ACustomer::class,'id_customer','id');
  }

  public function OrderStatus()
  {
    return $this->belongsTo(AStatus::class,'status','id');
  }


}
