<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class OrderDetailTemp extends Model
{
    protected $table = "order_detail_temps";
    protected $primaryKey = "id";

    public function getTempAttribute($data)
    {
        return json_decode($data);
    }
}
