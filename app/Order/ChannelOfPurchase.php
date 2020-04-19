<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class ChannelOfPurchase extends Model
{

    protected $table = "channel_of_purchases";
    protected $connection = 'order';
    protected $fillable = ['name', 'status'];

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1)->select('id', 'name', 'status');
    }

    public function productCategorySub()
    {
        return $this->hasMany(ProductCategorySub::class, "product_category_id", "id");
    }
}
