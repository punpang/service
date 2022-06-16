<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AAccessory extends Model
{
    protected $table = "a_accessory";

    protected $hidden = ['created_at', 'updated_at'];
}
