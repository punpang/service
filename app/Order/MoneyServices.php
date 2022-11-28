<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneyServices extends Model
{
    use SoftDeletes;

    protected $table = "money_services";
    protected $connection = "order";
    protected $primaryKey = "id";
    protected $appends = [
        "sumMoney", "sum_bank_notes", "total_money", "fee_format","sum_money_format"
    ];
    protected $hidden = ['created_at', 'updated_at'];

    //protected $filable = ["code", "price", "m1", "m2", "m3", "m4"];
    protected $guarded = [];

    public function MoneyServices()
    {
        return $this->belongsTo(OrderDetail::class);
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }

    public function getSumBankNotesAttribute()
    {
        return $this->thb20 +
            $this->thb50 +
            $this->thb100 +
            $this->thb500 +
            $this->thb1000;
    }

    public function category_money_service()
    {
        return $this->belongsTo(CategoryMoneyService::class);
    }

    public function getSumMoneyServiceAttribute()
    {
        return $this->sum("fee");
    }

    public function getTotalMoneyAttribute()
    {
        return number_format($this->fee + $this->SumMoney, 2);
    }

    public function getSumMoneyFormatAttribute()
    {
        return number_format($this->sumMoney, 2);
    }


    public function getSumMoneyAttribute()
    {
        return $this->Thb20Sum +
            $this->Thb50Sum +
            $this->Thb100Sum +
            $this->Thb500Sum +
            $this->Thb1000Sum;
    }

    public function getFeeFormatAttribute()
    {
        return number_format($this->fee, 2);
    }

    public function getThb20SumAttribute()
    {
        return $this->thb20 * 20;
    }

    public function getThb50SumAttribute()
    {
        return $this->thb50 * 50;
    }
    public function getThb100SumAttribute()
    {
        return $this->thb100 * 100;
    }

    public function getThb500SumAttribute()
    {
        return $this->thb500 * 500;
    }

    public function getThb1000SumAttribute()
    {
        return $this->thb1000 * 1000;
    }
}
