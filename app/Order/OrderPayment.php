<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Currency;

class OrderPayment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'order_id',
        'order_payment_method_id',
        'amount',
        'status',
        'image_slip_id',
        'bill_id'
    ];
    
    protected $hidden = ['created_at'];

    protected $table = "order_payments";
    protected $connection = "order";
    protected $fillable = [
        'order_id',
        'order_payment_method_id',
        'amount',
        'status',
        'image_slip_id',
        'bill_id'
    ];

    public static function FormatData($data)
    {
        $input = $data;
        $input['amount'] = Currency::change($input['amount']);
        return $input;
    }

    public static function getDataByOrderIDUseOnly($order_id)
    {
        return OrderPayment::whereOrderId($order_id)->whereStatus(1)->get();
    }

    public static function sumDeposit($order_id)
    {
        $sum = OrderPayment::whereOrderId($order_id)->whereStatus(1)->sum('amount');
        return number_format($sum,2);
    }

    public function order()
    {
        return $this->belongsTo(Order::class,"order_id","id");
    }

    public function OrderPaymentMethod()
    {
        return $this->belongsTo(OrderPaymentMethod::class,"order_payment_method_id","id");
    }
}
