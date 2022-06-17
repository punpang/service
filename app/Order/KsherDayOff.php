<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class KsherDayOff extends Model
{
    protected $table = "ksher_day_offs";
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];
    protected $appends = ["day_off_th"];

    public function ksherChannelPayment()
    {
        return $this->belongsTo(KsherChannelPayment::class, "ksher_channel_payment_id", "id");
    }

    public function getDayOffThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->day_off)->addYears(543)->format('d/m/Y');
    }
}
