<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class WongnaiPosBills extends Model
{
    protected $table = "wongnai_pos_bills";
    protected $guarded = [];
    protected $appends = [
        // "payment_date_time"
    ];

    public function getPaymentDateTimeAttribute()
    {
        // return "12345";

        // return \Carbon\Carbon::createFromFormat('DD/MM/YYYY', $this->payment_date)->format('d-m-Y');

        $date = \Carbon\Carbon::parse($this->payment_date)->format("Y-m-d");
        $time = \Carbon\Carbon::parse($this->payment_time)->format("H:i:s");
        return "$date $time";
    }
}
