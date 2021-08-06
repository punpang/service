<?php

namespace App\ShabuNoonee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BillSaleDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'bill_sale_id',
        'product_id',
        "price",
        "quantity",
        "sum_price",
        "status_free",
        "status"
    ];

    protected $table = "bill_sale_details";
}
