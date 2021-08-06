<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use App\ShabuNooNee\Product;
use App\ShabuNooNee\TableOrder;
use OwenIt\Auditing\Contracts\Auditable;

class TableOrderDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        "table_order_id",
        "product_id",
        "price",
        "quantity",
        "sum_price",
        "status_free",
    ];

    protected $table = "table_order_details";

    protected $fillable = [
        "table_order_id",
        "product_id",
        "price",
        "quantity",
        "sum_price",
        "status_free",
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    public function tableOrderId()
    {
        return $this->belongsTo(TableOrder::class, "table_order_id", "id");
    }

    public function dasdl()
    {
        return $this->groupBy("product_id");
    }
}
