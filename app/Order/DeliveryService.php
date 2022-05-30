<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeliveryService extends Model
{
    use softDeletes;
    protected $table = "delivery_services";
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];


    public function AOrder()
    {
        return $this->belongsTo(AOrder::class, "order_id", "id");
    }

    public function getDeliveryFeeAttribute($data)
    {
        return number_format($data, 2);
    }
}
