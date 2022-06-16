<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $hidden = ['created_at','updated_at'];

    protected $table = "order_statuses";
}
