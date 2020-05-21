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
        'token',
        'permission_to_publish'
    ];

    protected $table = "orders";
    protected $connection = 'order';
    protected $fillable = [
        'customer_id',
        'dateTime_get',
        'channel_of_purchase_id',
        'status',
        'token',
        'permission_to_publish'
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }

    public function CustomerNotFB()
    {
        return $this->belongsTo(Customer::class, "customer_id", "id")->select('id', 'name', 'phone');
    }

    public function OrderPayment()
    {
        return $this->hasMany(OrderPayment::class, "order_id", "id")->orderBy('status','DESC')->orderBy('updated_at',"DESC");
    }

    public function sumDeposit() //รวมเงินเฉพาะที่ใช้งาน
    {
        return $this->OrderPayment()->whereStatus(1)->sum('amount');
    }

    public function sumDepositFormat() //รวมเงินเฉพาะที่ใช้งาน
    {
        return number_format($this->sumDeposit(), 2);
    }

    public function ChannelOfPurchase()
    {
        return $this->belongsTo(ChannelOfPurchase::class, "channel_of_purchase_id", "id");
    }

    public function OrderSum()
    {
        return [
            'total' => $this->sumTotalFormat(),
            'deposit' => $this->sumDepositFormat(),
            'balance' => $this->balanceFormat()
        ];
    }

    public function OrderManages()
    {
        return ['Customer', 'ChannelOfPurchase', 'OrderStatus', 'SlipNotVerifyOnly'];
    }

    public function OrderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id')->whereStatus(1);
    }

    public function OrderDetailNoUse()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id')->whereStatus(0);
    }

    public function CountOrderDetail()
    {
        return $this->OrderDetail()->count();
    }

    public function CountOrderDetailNoUse()
    {
        return $this->OrderDetailNoUse()->count();
    }

    public function sumTotal() //รวมเงินเฉพาะที่ใช้งาน
    {
        return $this->OrderDetail()->sum('sum_price');
    }

    public function sumTotalFormat() //รวมเงินเฉพาะที่ใช้งาน
    {
        return number_format($this->sumTotal(), 2);
    }

    public function balance() //รวมเงินเฉพาะที่ใช้งาน
    {
        return $this->sumTotal() - $this->sumDeposit();
    }

    public function balanceFormat() //รวมเงินเฉพาะที่ใช้งาน
    {
        return number_format($this->balance(), 2);
    }

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1);
    }

    public function scopeTodayOrder()
    {
        return $query = $this->whereDate('dateTime_get', \Carbon\Carbon::now()->format('Y-m-d'))->where('order_status_id','<=',7)
            ->orderBy('dateTime_get', 'ASC')
            ->with($this->OrderManages());
    }

    public function scopeTomorrowOrder()
    {
        return $query = $this->whereDate('dateTime_get', \Carbon\Carbon::now()->addDays(1)->format('Y-m-d'))
            ->orderBy('dateTime_get', 'ASC')
            ->with($this->OrderManages());
    }

    public function scopeCreatedOrder()
    {
        return $query = $this->where('order_status_id', '1')
            ->whereDate('dateTime_get', '>=', \Carbon\Carbon::now()->format('Y-m-d'))
            ->with($this->OrderManages())
            ->orderBy('dateTime_get', 'ASC');
    }

    public function scopeNotifyOrder()
    {
        return $query = $this->whereIn('order_status_id', ['2', '3'])
            ->where('dateTime_get', '>=', \Carbon\Carbon::now()->format('Y-m-d'))
            ->with($this->OrderManages())
            ->orderBy('dateTime_get', 'ASC');
    }

    public function DateTimeFormatTH($dateTime)
    {
        return \Carbon\Carbon::parse($dateTime)->addYears(543)->format('d-m-Y H:i:s');
    }

    public function SlipNotVerify() //slip ที่ยังไม่ได้ตรวจสอบ และ ไม่ผ่าน
    {
        return $this->hasMany(Slip::class, 'order_id', 'id')->whereIn('slip_verify_id', [1, 3]);
    }

    public function SlipVerify() // slip ผ่าน
    {
        return $this->hasMany(Slip::class, 'order_id', 'id')->where('slip_verify_id', 2);
    }

    public function CountSlipNotVerify()
    {
        return $this->SlipNotVerify()->count();
    }

    public function SlipNotVerifyOnly() //slip ที่ยังไม่ได้ตรวจสอบ และ ไม่ผ่าน
    {
        return $this->hasMany(Slip::class, 'order_id', 'id')->where('slip_verify_id', 1);
    }

    public function CountSlipNotVerifyOnly()
    {
        return $this->SlipNotVerifyOnly()->count();
    }


}
