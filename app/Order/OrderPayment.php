<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderPayment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'order_id',
        'payment_method_id',
        'amount',
        'status',
        'image_slip_id'
    ];
    
    protected $hidden = ['created_at','updated_at'];

    protected $table = "order_payments";
    protected $connection = "order";
    protected $fillable = [
        'order_id',
        'payment_method_id',
        'amount',
        'status',
        'image_slip_id'
    ];
}
