<?php

namespace App\Punpang;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $connection = 'punpang';

    public function prices()
    {
        return $this->hasMany(Price::class, "id_product", "id")->orderBy("price","asc");
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, "id", "id_product");
    }


}
