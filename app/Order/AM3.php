<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM3 extends Model
{
    protected $table = "a_m3";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

}
