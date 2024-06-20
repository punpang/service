<?php

namespace App\Order;

use App\Pos\Goods;
use App\Order\ACustomer;
use Illuminate\Database\Eloquent\Model;

class ProductInterest extends Model
{
    protected $table = "product_interests";
    protected $primaryKey = "id";
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];


    public function pos_goods(){
        // return $this->hasMany(CustomerScore::class, "customer_id", "id");

        return $this->belongsTo(Goods::class,"pos_goods_id","id");
    }

    public function customer(){
        // return $this->hasMany(CustomerScore::class, "customer_id", "id");

        return $this->belongsTo(ACustomer::class,"customer_id","id");
    }
}
