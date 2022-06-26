<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM1 extends Model
{
    protected $table = "a_m1";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];
    public $timestamps = false;
}
