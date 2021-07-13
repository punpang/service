<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DiningTable extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        "user_id",
        "status_id",
        "count_Infant",
        "count_Children",
        "count_Adolescence",
        "count_Adult",
        "count_Elder",
        "price_Infant",
        "price_Children",
        "price_Adolescence",
        "price_Adult",
        "price_Elder",
        "sumPrice",
        "priceRange_id"
    ];

    protected $table = "dining_tables";
    protected $fillable = [
        "user_id",
        "status_id",
        "count_Infant",
        "count_Children",
        "count_Adolescence",
        "count_Adult",
        "count_Elder",
        "price_Infant",
        "price_Children",
        "price_Adolescence",
        "price_Adult",
        "price_Elder",
        "sumPrice",
        "priceRange_id",
        "time_end"
    ];

    public function diningTableStatus()
    {
        return $this->belongsTo(DiningTableStatus::class, "status_id", "id");
    }

    public static function checkTable($tableNumber)
    {
        return self::whereUserId($tableNumber)->whereIn("status_id", [1, 2, 3])->first();
    }
}
