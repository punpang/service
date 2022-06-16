<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class PromotionProduct extends Model
{
    protected $table = "promotion_products";

    public function getPriceNormalAttribute($data)
    {
        return number_format($data, 2);
    }

    public function getPriceSpecialAttribute($data)
    {
        return number_format($data, 2);
    }

    public function promotion()
    {
        return $this->belongsTo(promotion::class, "promotion_id", "id");
    }
}
