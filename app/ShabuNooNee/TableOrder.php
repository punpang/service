<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use App\ShabuNooNee\DiningTable;

class TableOrder extends Model
{
    protected $table = "table_orders";

    public function diningTableId()
    {
        return $this->belongsTo(DiningTable::class,"dining_table_id","id");
    }
}
