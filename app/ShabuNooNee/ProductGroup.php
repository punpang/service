<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name',
        'status'
    ];
    protected $table = "product_groups";

    protected $fillable = [
        'name', 'status'
    ];
}
