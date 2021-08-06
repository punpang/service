<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class DiningTableStatus extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'title',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
