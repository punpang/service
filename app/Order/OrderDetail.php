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

    public static function sumPrice($order_id) //รวมเงินเฉพาะที่ใช้งาน
    {
        $data = OrderDetail::whereOrderId($order_id)->whereStatus(1)->sum('sum_price');
        return number_format($data);
    }

    public static function getByOrderIDAll($order_id)
    {
        return OrderDetail::whereOrderId($order_id)->orderBy('status', "DESC")->with('Product.ProductTagUseOnly.ProductCategorySubUseOnly.ProductCategory')->with('Product.ProductImage')->get();
    }
}
