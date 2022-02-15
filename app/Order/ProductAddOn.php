<?php

namespace App\Order;

use App\Order\GoodsAddOn;
use Illuminate\Database\Eloquent\Model;

class ProductAddOn extends Model
{
    protected $table = "product_add_ons";
    protected $primaryKey = "id";

    // protected $appends = ["name_add_on"];

    public function goodsAddOn()
    {
        return $this->hasOne(GoodsAddOn::class, "id", "goods_add_on_id");
    }

    // public function getNameAddOnAttribute()
    // {
    //     return $this->goodsAddOn->name;
    // }
}
