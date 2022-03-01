<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class ChannelPayment extends Model
{
    protected $table = "channel_payments";

    protected $connection = 'order';
    protected $hidden = ['created_at', 'updated_at'];

}
