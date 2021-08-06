<?php

namespace App\Shabunoonee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CookingType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'title',
        'status',
    ];
    
    protected $table = "cooking_types";
    protected $hidden = ["created_at", "updated_at"];
}
