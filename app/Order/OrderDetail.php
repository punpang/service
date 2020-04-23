<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'order_id',
        'product_id',
        'write_status',
        'write',
        'note_status',
        'note',
        'price',
        'quantity',
        'sum_price',
        'upload_image_status',
        'permission_to_publish',
        'status'
    ];

    protected $table = "order_details";
    protected $connection = "order";
    protected $fillable = [
        'order_id',
        'product_id',
        'write_status',
        'write',
        'note_status',
        'note',
        'price',
        'quantity',
        'sum_price',
        'upload_image_status',
        'permission_to_publish',
        'status'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); //->exclude()
    }

    public static  function sumPrice()
    {
        return number_format(OrderDetail::sum("price"), 2);
    }
}
