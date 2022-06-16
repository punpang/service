<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Reward extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name',
        'value',
    ];

    protected $table = "rewards";
    protected $hidden = ["created_at", "updated_at"];
}
