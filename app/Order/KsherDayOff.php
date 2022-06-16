<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class KsherDayOff extends Model
{
    protected $table = "ksher_day_offs";
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];

    public function ksherChannelPayment()
    {
        return $this->belongsTo(KsherChannelPayment::class, "ksher_channel_payment_id", "id");
    }
}
