<?php

namespace App\Order;

use App\Order\APrice;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "order_details";
    protected $primaryKey = "id";

    protected $fillable = [
        "order_id",
        "a_price_id",
        "price",
        "status_use",
        "message",
        "detail",
        "is_show_public"
    ];

    public function aPrice()
    {
        return $this->belongsTo(APrice::class,);
    }
}
