<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PriceRange extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'title',
        'price_Infant',
        "price_Children",
        "price_Adolescence",
        "price_Adult",
        "price_Elder",
        "status",
        "price_Elder"
    ];

    protected $table = "price_ranges";

    protected $hidden = ['created_at', 'updated_at'];

    public static function getPriceRange($id)
    {
        return self::whereId($id)->first();
    }
}
