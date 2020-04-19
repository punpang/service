<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class PaymentChannel extends Model
{
  protected $table = 'payment_channels';

  protected $connection = 'order';

  // public $timestamps = false;

  public static function StatusUse()
  {
    return PaymentChannel::where('status','1')->select('id','name')->get();
  }
}
