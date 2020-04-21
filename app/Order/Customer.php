<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    //auditing
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name',
        'phone',
    ];

    protected $table = 'customers';

    protected $connection = 'order';
    protected $hidden = ['created_at','updated_at'];

    protected $fillable = [
        'name', 'phone'
    ];

    //public $timestamps = false;
}
