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
    public $hidden = ['updated_at'];
    
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

    public function silpUnVerifyReasoning()
    {
        return $this->belongsTo(SilpUnVerifyReasoning::class, 'slip_un_verify_reasoning_id', 'id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function GoogleOcr()
    {
        return $this->hasMany('App\GoogleOcr','google_image_path','path');
    }
}
