<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'customer_id',
        'dateTime_get',
        'channel_of_purchase_id',
        'status',
        'token'
    ];

    protected $table = "orders";
    protected $connection = 'order';
    protected $fillable = [
        'customer_id',
        'dateTime_get',
        'channel_of_purchase_id',
        'status',
        'token'
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }

    public function ChannelOfPurchase()
    {
        return $this->belongsTo(ChannelOfPurchase::class, "channel_of_purchase_id", "id");
    }

    public function OrderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1);
    }

    public function scopeTodayOrder()
    {
        return $query = $this->whereDate('dateTime_get', \Carbon\Carbon::now()->format('Y-m-d'))->orderBy('dateTime_get', 'ASC');
    }

    public function scopeTomorrowOrder()
    {
        return $query = $this->whereDate('dateTime_get', \Carbon\Carbon::now()->addDays(1)->format('Y-m-d'))->orderBy('dateTime_get', 'ASC');
    }

    public function scopeCreatedOrder()
    {
        return $query = $this->where('order_status_id', '1')
            ->whereDate('dateTime_get', '>=', \Carbon\Carbon::now()->format('Y-m-d'))
            ->orderBy('dateTime_get', 'ASC');
    }

    public function scopeNotifyOrder()
    {
        return $query = $this->where('order_status_id', '2')->orderBy('dateTime_get', 'ASC');
    }

    public function DateTimeFormatTH($dateTime) 
    {
        return \Carbon\Carbon::parse($dateTime)->addYears(543)->format('d-m-Y H:i:s');
    }
}
