<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class orderDetail extends Model
{
    protected $hidden = ['created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo(PromotionProduct::class, "product_id", "id");
    }
}
