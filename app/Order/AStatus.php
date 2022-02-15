<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AStatus extends Model
{
    protected $table = "a_status";
    protected $connection = "order";
}
