<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class SmsMessages extends Model
{
    protected $table = "sms_messages";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];
    protected $appends = [];
}
