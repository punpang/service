<?php

namespace App\Order;

use App\Order\LotteryRegister;
use Illuminate\Database\Eloquent\Model;

class LotteryPeriod extends Model
{
    protected $table = "lottery_periods";
    protected $guarded = [];
    protected $appends = ["date_th"];

    public function getDateThAttribute()
    {
        return \Carbon\Carbon::parse($this->date)->addYears(543)->format("d/m/Y");
    }

    public function lotteryRegisters()
    {
        return $this->hasMany(LotteryRegister::class, "lottery_period_id", "id");
    }

    public static function is_awarded($date, $take = null)
    {
        $lotterys = LotteryPeriod::where("date", "<=", $date)
            ->orderBy("date", "DESC")
            // ->where("is_awarded", false)
            ->take($take)
            ->get()
            ->where("is_awarded", false);

        return $lotterys;
    }
}
