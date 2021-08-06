<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class orderDetail extends Model
{

    public function product()
    {
        return $this->belongsTo(PromotionProduct::class, "product_id", "id");
    }
}
