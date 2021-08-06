<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function customer()
    {
        return $this->belongsTo(customer::class, "customer_id", "id");
    }

    public function orderDetails()
    {
        return $this->hasMany(orderDetail::class, "order_id", "id");
    }

    public function orderDetails2()
    {
        return $this->hasMany(orderDetail::class, "order_id", "id")->select("id", "order_id", "product_id");
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, "order_status_id", "id");
    }

    public function promotion()
    {
        return $this->belongsTo(promotion::class, "promotion_id", "id");
    }

    public function payment()
    {
        return $this->belongsTo(payment::class, "id", "order_id");
    }

    // public function getCreatedAtAttibute($date)
    // {
    //     return \Carbon\Carbon::parse($date)->addYear(543)->format("d-m-Y H:i:s");
    // }

    public function getCreatedAtAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->addYears(543)->format('d-m-Y H:i:s');
    }

    public static function queue($promotion_id, $perHour = 13, $timeStart = 10)
    {
        $orders = Order::where("promotion_id", $promotion_id)
            ->whereIn("order_status_id", [2, 3, 4, 5])
            ->where("status_use", 1)
            ->count();

        $time_get_before = number_format(($orders / $perHour) + $timeStart, 2);
        $time_get_explode = explode(".", $time_get_before);

        $H = $time_get_explode[0];

        if ($time_get_explode[1] <= 50) {
            $i = "00";
        } else {
            $i = "30";
        }

        return $H . ":" . $i . ":00";
    }

    public static function overDateEnd($date_end, $order_status_id)
    {
        if (
            $date_end < now()->format("d-m-Y") //เวลาสิ้นสุดโปรโมชัน < วันนี้
            && $order_status_id === 1 // สถานะออร์เดอร์ === 1 (สร้างรายการสั่งซื้อแล้ว)
        ) {
            return true;
        }
    }
}
