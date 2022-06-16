<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class ADiscount extends Model
{
    protected $table = "a_discount";
    protected $hidden = ['created_at', 'updated_at'];

}
