<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class promotion extends Model
{
    public function getDateGetAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->addYears(543)->format('d-m-Y');
    }

    public function getDateStartAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->addYears(543)->format('d-m-Y');
    }

    public function getDateEndAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->addYears(543)->format('d-m-Y');
    }

    public static function overDateEnd($promotion_id)
    {
        $payment = self::where("id", $promotion_id)
            ->where("date_end", "<", now()->format("d-m-Y"))
            ->first();

        return $payment;
    }

    public static function notDateStartEnd($promotion_id)
    {
        $payment = self::where("id", $promotion_id)
            ->where('date_start', ">", now()->format("Y-m-d")) // 3 > 4
            ->where("date_end", "<", now()->format("d-m-Y"))
            ->first();

        return $payment;
    }

    public static function DateInStartEnd($promotion_id)
    {
        $payment = self::where("id", $promotion_id)
            ->where('date_start', "<", now()->format("Y-m-d")) // 3 > 4
            ->where("date_end", ">", now()->format("d-m-Y")) //3 > 3
            ->first();

        return $payment;
    }

    public function usePromotionProducts()
    {
        return $this->hasMany(PromotionProduct::class, 'promotion_id', 'id')->where('status_use', 1);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, "promotion_id", "id");
        // ->groupBy("order_status_id");
    }
}
