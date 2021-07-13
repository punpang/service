<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    protected $table = "price_ranges";

    public static function getPriceRange($id)
    {
        return self::whereId($id)->first();
    }
}
