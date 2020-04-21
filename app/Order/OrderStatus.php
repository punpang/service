<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderStatus extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name'
    ];
    
    protected $hidden = ['created_at','updated_at'];


    protected $table = "order_statuses";
    protected $connection = "order";
    protected $fillable = [
        'name'
    ];
}
