<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AStatus extends Model
{
    protected $table = "a_status";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

}
