<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdjustExcessPayment extends Model
{
    use softDeletes;
    protected $table = "adjust_excess_payments";
    protected $guarded = [];
}
