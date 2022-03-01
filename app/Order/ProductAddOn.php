<?php

namespace App\Order;

use App\Order\GoodsAddOn;
use Illuminate\Database\Eloquent\Model;

class ProductAddOn extends Model
{
    protected $table = "product_add_ons";
    protected $primaryKey = "id";
    protected $hidden = ['created_at', 'updated_at'];


    protected $guarded = [];

    // protected $appends = ["name_add_on"];

    public function goodsAddOn()
    {
        return $this->belongsTo(GoodsAddOn::class, "goods_add_on_id", "id");
    }

    // public function getNameAddOnAttribute()
    // {
    //     return $this->goodsAddOn->name;
    // }
}
