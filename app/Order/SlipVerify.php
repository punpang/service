<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SlipVerify extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'text'
    ];

    protected $table = "slip_verifies";
    public $hidden = ['created_at','updated_at'];
    protected $connection = 'order';
    protected $fillable = [
        'text'
    ];

    
}
