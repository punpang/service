<?php

namespace App\ShabuNoonee;

use App\ShabuNooNee\Product;
use Illuminate\Database\Eloquent\Model;

class CookingBroth extends Model
{
    protected $table = "cooking_broths";

    protected $hidden = ["created_at", "updated_at"];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
