<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class KsherChannelPayment extends Model
{
    protected $table = "ksher_channel_payments";
    protected $hidden = ['created_at', 'updated_at'];

}
