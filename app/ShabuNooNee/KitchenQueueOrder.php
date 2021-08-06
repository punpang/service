<?php

namespace App\ShabuNoonee;

use App\ShabuNooNee\TableOrder;
use App\ShabuNooNee\TableOrderDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class KitchenQueueOrder extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'dining_table_id',
        'queue_id',
        "user_id",
        "format_id",
        "status_done",
    ];

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

    public function OrderTable()
    {
        return $this->belongsTo(TableOrder::class, "queue_id", "id");
    }
}
