<?php

namespace App\Order;

use App\Order\AOrder;
use App\Order\APrice;
use App\Order\OrderDetailAddOn;
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

    protected $fillable = [
        "order_id",
        "a_price_id",
        "price",
        "status_use",
        "message",
        "detail",
        "is_show_public"
    ];

    protected $appends = ["sum_all"];



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

    public function productPrototypes()
    {
        return $this->hasMany(OrderProductPrototype::class);
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
}
