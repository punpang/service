<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    protected $table = "price_ranges";

    protected $hidden = ['created_at', 'updated_at'];

    public static function getPriceRange($id)
    {
        return self::whereId($id)->first();
    }
}
