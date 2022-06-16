<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class OrderChannel extends Model
{
    protected $table = "order_channels";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];
}
