<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderPaymentMethod extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = ['name', 'status',];

    protected $hidden = ['created_at','updated_at'];

    protected $table = "order_payment_methods";
    protected $connection = "order";
    protected $fillable = ['name', 'status',];
}
