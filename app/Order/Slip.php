<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Slip extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'order_id',
        'path',
        'use',
        'verify',
        'ref',
    ];

    protected $table = "slips";
    protected $connection = 'order';
    protected $fillable = [
        'order_id',
        'path',
        'use',
        'verify',
        'ref',
    ];

    public function SlipVerify()
    {
        return $this->belongsTo(SlipVerify::class, 'slip_verify_id', 'id');
    }
}
