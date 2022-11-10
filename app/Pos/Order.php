<?php

namespace App\Pos;

use App\Pos\Goods;
use App\Order\AOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use softDeletes;

    protected $table = "pos_orders";
    protected $connection = "order";
    // protected $hidden = ['created_at', 'updated_at'];
    // public $timestamps = false;
    protected $appends = [];
    protected $guarded = [];

    public function setTotalAttribute()
    {
        return $this->attributes["total"] = $this->price * $this->quantity;
    }

    public function posGoods(){
        return $this->belongsTo(Goods::class);
    }

    public function order(){
        return $this->belongsTo(AOrder::class);
    }
}
