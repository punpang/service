<?php

namespace App\Order;

use App\Order\Coupons;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponUsed extends Model
{
    use softDeletes;

    protected $table = "coupon_useds";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [];
    protected $guarded = [];

    public function coupon()
    {
        return $this->belongsTo(Coupons::class, "coupon_id", "id");
    }

}
