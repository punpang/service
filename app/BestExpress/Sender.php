<?php

namespace App\BestExpress;

use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
  protected $table = 'senders';

  protected $connection = 'best';

  // protected $primaryKey = 'tel';

  public static function DataValidate()
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
  }

  public function Payment()
  {
    return $this->belongsTo(Payment::class,'id','sender_id');
  }
}
