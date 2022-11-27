<?php

namespace App\Order;

use App\Order\ProductAddOn;
use Illuminate\Database\Eloquent\Model;

class OrderDetailAddOn extends Model
{
    protected $table = "order_detail_add_ons";
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = [];


    public function productAddOn()
    {
        return $this->belongsTo(ProductAddOn::class, "product_add_on_id", "id");
    }



    public function getPriceAddOnAttribute()
    {
        return $this->productAddOn->price >= 0 ? $this->productAddOn->price : 0;
    }
}
