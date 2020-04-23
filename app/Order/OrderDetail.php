<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'order_id', 'price' ,'product_id', 'write_status', 'write', 'note_status', 'note', 'status' , 'upload_image_status'
    ];

    protected $table = "order_details";
    protected $connection = "order";
    protected $fillable = [
        'order_id', 'price' ,'product_id', 'write_status', 'write', 'note_status', 'note', 'status', 'upload_image_status'
    ];

    protected $hidden = ['created_at','updated_at'];

    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id','id');//->exclude()
    }

    public static  function sumPrice()
    {
        return number_format(OrderDetail::sum("price"),2);
    }
}
