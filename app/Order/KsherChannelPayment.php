<?php

namespace App\Order;

use App\Order\KsherDayOff;
use Illuminate\Database\Eloquent\Model;

class KsherChannelPayment extends Model
{
    protected $table = "ksher_channel_payments";
    protected $hidden = ['created_at', 'updated_at', "ksher_day_off"];

    // protected $appends = ["ksher_day_off_status"];

    public function ksherDayOff()
    {
        return $this->hasOne(KsherDayOff::class, "ksher_channel_payment_id", "id");
    }

    public function getKsherDayOffStatusAttribute()
    {
        if ($this->ksherDayOff) {
            return true;
        } else {
            return false;
        }
    }
}
