<?php

namespace App\ShabuNoonee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BillSale extends  Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'dining_table_id',
        'total',
        "payment_amount",
        "discount",
        "change",
        "user_id",
    ];
    protected $table = "bill_sales";
}
