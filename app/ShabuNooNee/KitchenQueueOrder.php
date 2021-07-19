<?php

namespace App\ShabuNoonee;

use App\ShabuNooNee\TableOrderDetail;
use Illuminate\Database\Eloquent\Model;

class KitchenQueueOrder extends Model
{
    protected $table = "kitchen_queue_orders";

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function tableOrderDetails()
    {
        return $this->hasMany(TableOrderDetail::class, "table_order_id", "queue_id");
    }

    public function sumQuantity()
    {
        return $this->tableOrderDetails()->sum("quantity");
    }
}
