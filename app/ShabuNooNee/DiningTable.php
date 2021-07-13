<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;

class DiningTable extends Model
{
    protected $table = "dining_tables";

    public function diningTableStatus()
    {
        return $this->belongsTo(DiningTableStatus::class, "status_id", "id");
    }

    public static function checkTable($tableNumber)
    {
        return self::whereUserId($tableNumber)->whereIn("status_id", [1, 2, 3])->first();
    }
}
