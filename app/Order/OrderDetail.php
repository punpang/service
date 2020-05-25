<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Currency;

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
        'status',
        'finished_product_image',
        'hide_money'
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
        'status',
        'finished_product_image',
        'hide_money'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); //->exclude()
    }

    public static function sumPrice($order_id) //รวมเงินเฉพาะที่ใช้งาน
    {
        $data = OrderDetail::whereOrderId($order_id)->whereStatus(1)->sum('sum_price');
        return number_format($data, 2);
    }

    public static function getByOrderIDAll($order_id)
    {
        return OrderDetail::whereOrderId($order_id)->orderBy('status', "DESC")
            ->with('Product.ProductTagUseOnly.ProductCategorySubUseOnly.ProductCategory')
            ->with('Product.ProductImage')->get();
    }

    public function Deposit()
    {
        return $this->hasMany('App\Order\OrderPayment', 'order_id', 'order_id')->where('status', '1')->sum('amount');
    }

    public function Order()
    {
        return $this->belongsTo('App\Order\Order', 'order_id', 'id');
    }

    public function uploadImage()
    {
        return $this->hasOne(SentLinkForUploadImage::class, 'order_detail_id', 'id');
    }

    public static function FormatData($data)
    {
        $input = $data;
        $input['price'] = Currency::change($input['price']);
        $input['sum_price'] = Currency::change($input['sum_price']);

        return $input;
    }

    public function sumTotal() //รวมเงินเฉพาะที่ใช้งาน
    {
        return $this->whereStatus(1)->sum('sum_price');
    }
}
