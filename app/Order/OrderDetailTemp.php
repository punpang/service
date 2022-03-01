<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class OrderDetailTemp extends Model
{
    protected $table = "order_detail_temps";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];


    public function getTempAttribute($data)
    {
        return json_decode($data);
    }
    public function setTempAttribute($data)
    {
        return $this->attributes["temp"] = json_encode($data);
    }


}
