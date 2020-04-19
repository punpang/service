<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'product_id','write_status','write','note_status','note','status'
    ];

    protected $table = "order_details";
    protected $connection = "order";
    protected $fillable = [
        'product_id','write_status','write','note_status','note','status'
    ];
}
