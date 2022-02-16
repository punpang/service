<?php

namespace App\Order;

use App\Order\ProductAddOn;
use Illuminate\Database\Eloquent\Model;

class OrderDetailAddOn extends Model
{
    protected $table = "order_detail_add_ons";
    protected $guarded = [];

    public function productAddOn()
    {
        return $this->belongsTo(ProductAddOn::class,"product_add_on_id","id");
    }
}
