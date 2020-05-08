<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Image extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'order_detail_id',
        'public_id',
        'url',
        'main',
        'type'
    ];

    protected $table = "images";
    protected $connection = "order";
    protected $fillable = [
        'order_detail_id',
        'public_id',
        'url',
        'main',
        'type'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
