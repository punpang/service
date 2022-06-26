<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM2 extends Model
{
    protected $table = "a_m2";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];
    public $timestamps = false;
}
