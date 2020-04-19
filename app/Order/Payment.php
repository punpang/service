<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $table = 'payments';

  protected $connection = 'order';

  // public $timestamps = false;
  public function CreatedAtFormat()
  {
    return \Carbon\Carbon::parse($this->created_at)->addYears(543)->format('d-m-Y H:i:s');
  }

  public function PaymentChannel()
  {
    return $this->belongsTo(PaymentChannel::class,'payment_channel_id','id');
  }
}
