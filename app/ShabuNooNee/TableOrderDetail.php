<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use App\ShabuNooNee\Product;

class TableOrderDetail extends Model
{
    protected $table = "table_order_details";
    protected $fillable = [
        "table_order_id",
        "product_id",
        "price",
        "quantity",
        "sum_price",
        "status_free",
    ];
}
