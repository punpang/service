<?php

namespace App\Order;

use App\Order\AOrder;
use App\Order\APrice;
use App\Order\OrderTags;
use App\Order\OrderDetailAddOn;
use App\Order\ImageFromCustomer;
use App\Order\OrderImageForMenu;
use App\Order\OrderProductPrototype;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model implements Auditable
{
    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [];
    protected $table = "order_details";
    protected $primaryKey = "id";
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        "order_id",
        "a_price_id",
        "price",
        "status_use",
        "message",
        "detail",
        "is_show_public"
    ];

    protected $appends = ["sum_all", "sum_money_customer", "sum_money_service"];

    public function aPrice()
    {
        return $this->belongsTo(APrice::class);
    }

    public function aOrder()
    {
        return $this->belongsTo(AOrder::class, "order_id", "id");
    }

    public function addOns()
    {
        return $this->hasMany(OrderDetailAddOn::class);
    }

    public function addOn()
    {
        return $this->hasOne(OrderDetailAddOn::class)->orderBy("created_at", "desc");
    }

    public function imageFromCustomers()
    {
        return $this->hasMany(ImageFromCustomer::class);
    }

    public function productPrototypes()
    {
        return $this->hasMany(OrderProductPrototype::class);
    }

    public function imageForMenus()
    {
        return $this->hasMany(OrderImageForMenu::class);
    }

    public function MoneyServices()
    {
        return $this->hasMany(MoneyServices::class);
    }

    public function getSumMoneyCustomerAttribute()
    {
        return $this->MoneyServices->sum("sumMoney");
    }

    public function getSumMoneyServiceAttribute()
    {
        return $this->MoneyServices()->sum("fee");
    }

    public function getSumAllMoneyServiceAttribute()
    {
        return $this->sum("SumMoneyService");
    }

    public function imageGoodsReviewToCustomers()
    {
        return $this->hasMany(ImageGoodsReviewToCustomer::class);
    }

    public function getSumAllAttribute()
    {
        return [
            "total" => $this->sum_total,
            "add_on" => $this->sum_add_on,
        ];
    }

    public function getSumAddOnAttribute()
    {
        return number_format($this->addOns()->sum("price"), 2);
    }

    public function getSumTotalAttribute()
    {
        return number_format($this->price + $this->sum_add_on, 2);
    }

    public function onlyTrashed()
    {
        return $this->withTrashed();
    }

    public function orderTags(){
        return $this->hasMany(OrderTags::class);
    }
}
