<?php

namespace App\ShabuNoonee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CookingDetailStatusStep extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'title',
        'key',
        "cssClass",
    ];

    protected $table = "cooking_detail_status_steps";
    protected $hidden = ["created_at", "updated_at"];
}
