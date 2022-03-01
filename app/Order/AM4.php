<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM4 extends Model
{
    protected $table = "a_m4";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

}
