<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AService extends Model
{
    protected $table = "a_service";
    protected $hidden = ['created_at', 'updated_at'];

}
