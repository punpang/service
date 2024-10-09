<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendSmsAgain extends Model
{
    protected $table = "send_sms_agains";
    protected $connection = "order";
    // protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];


}
