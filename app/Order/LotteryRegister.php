<?php

namespace App\Order;

use App\Order\ACustomer;
use Illuminate\Database\Eloquent\Model;

class LotteryRegister extends Model
{
    protected $table = "lottery_registers";
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(ACustomer::class);
    }

    public function lotteryPeriod()
    {
        return $this->belongsTo(LotteryPeriod::class);
    }

    public static function get_lottery_me($lottery_period_id, $customer_id)
    {
        $lottery_me_get = LotteryRegister::where("lottery_period_id", $lottery_period_id)
            ->where("customer_id", $customer_id)
            ->get();

        $lottery_me = [];
        foreach ($lottery_me_get as $me) {
            $lottery_me[] = $me->lucky_number;
        }

        return $lottery_me;
    }

    public static function reserve_lotterys($lottery)
    {
        $reserve_lotterys = [];
        foreach ($lottery->lotteryRegisters as $lottery_register) {
            $reserve_lotterys[] = $lottery_register->lucky_number;
        }
        return $reserve_lotterys;
    }
}
