<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use App\ShabuNooNee\DiningTable;
use App\ShabuNooNee\TableOrderDetail;

class TableOrder extends Model
{
    protected $table = "table_orders";

    public function diningTableId()
    {
        return $this->belongsTo(DiningTable::class, "dining_table_id", "id");
    }

    public function billSale()
    {
        return $this->belongsTo(billSale::class, "dining_table_id", "dining_table_id");
    }

    public function detailOrderTables()
    {
        return $this->hasMany(TableOrderDetail::class, "table_order_id", "id");
    }

    public function sumQuantity()
    {
        return $this->tableOrderDetail()->sum("quantity");
    }

    public static function setStatus($table_order_id, $status)
    {
        $update = self::find($table_order_id);
        $update->status = $status;
        $update->save();
    }
}
