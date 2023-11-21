<?php

namespace App\Order;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupons extends Model
{
    use softDeletes;

    protected $table = "coupons";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ["date_start_th", "date_end_th"];
    protected $guarded = [];

    public function getDateStartThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->date_start)->addYears(543)->format('d-m-Y');
    }

    public function getDateEndThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->date_end)->addYears(543)->format('d-m-Y');
    }

    public static function processingCouponsReturnDiscount($code, $sum_price = 0, $customer_id = null)
    {
        $coupons = Coupons::where("code", $code)->first();

        if (!$coupons) {
            return [
                "icon" => "warning",
                "title" => "ไม่พบคูปอง",
                "status" => "fail"
            ];
        }

        if ($coupons->minimum > $sum_price) {
            return [
                "icon" => "warning",
                "title" => "ไม่ถึงยอดขั้นต่ำ",
                "status" => "fail"
            ];
        }

        if ($coupons->limit_times < $coupons->used_times) {
            //100 < 101

            return [
                "icon" => "warning",
                "title" => "คูปองนี้ ถูกใช้เต็มจำนวนแล้ว",
                "status" => "fail"
            ];
        }

        $now = Carbon::now()->format("Y-m-d");
        if ($coupons->date_start >= $now) {
            // 30/05/66 < 30/05/66      F
            // 29/05/66 < 30/05/66      T
            // 31/05/66 < 30/05/66      F

            return [
                "icon" => "warning",
                "title" => "คูปองนี้ ยังไม่ถึงวันที่เริ่มต้นใช้งาน",
                "status" => "fail"
            ];
        }

        if ($coupons->date_end < $now) {
            // 29/05/66 > 30/05/66     F
            // 30/05/66 > 30/05/66     F            
            // 31/05/66 > 30/05/66     T

            return [
                "icon" => "warning",
                "title" => "คูปองนี้ วันใช้งานสิ้นสุดแล้ว",
                "status" => "fail"
            ];
        }

        if ($coupons->customer_id != null) {
            if ($coupons->customer_id != $customer_id) {
                return [
                    "icon" => "warning",
                    "title" => "คูปองนี้ ใช้ได้เฉพาะลูกค้าที่กำหนดไว้",
                    "status" => "fail"
                ];
            }
        }

        $discount = $sum_price * $coupons->percent / 100;
        $discount = $discount >= $coupons->maximum ? $coupons->maximum : $discount;

        return [
            "coupon" => $coupons,
            "discount" => $discount,
            "status" => "success"
        ];
    }
}
