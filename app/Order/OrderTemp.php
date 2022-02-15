<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class OrderTemp extends Model
{
    protected $table = "order_temps";
    protected $primaryKey = "id";

    protected $fillable = [
        "customer_id", "temp"
    ];

    public function getTempAttribute($data)
    {
        return json_decode($data);
    }

    public function orderDetailTemps()
    {

        return $this->hasMany(OrderDetailTemp::class,);
    }
}
