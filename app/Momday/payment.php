<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $hidden = ['created_at','updated_at'];

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, "status_payment", "id");
    }

    public function getCreatedAtAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->addYears(543)->format('d-m-Y H:i:s');
    }
}
