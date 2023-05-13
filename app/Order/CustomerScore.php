<?php

namespace App\Order;

use App\Order\ACustomer;
use App\order\AHistoryPayed;
use Illuminate\Database\Eloquent\Model;

class CustomerScore extends Model
{
    protected $table = "customer_scores";

    // protected $fillable = [
    //     "point", "customer_id", "expiration_date"
    // ];

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];


    // public $divisor = 50;

    // public function setPointAttribute($point)
    // {
    //     if ($point > 0) {
    //         $this->attributes['point'] = $point / $this->divisor;
    //     } else {
    //         $this->attributes['point'] = $point;
    //     }
    // }

    // public function setExpirationDateAttribute($expiration_date)
    // {
    //     return $this->attributes['expiration_date'] = \Carbon\Carbon::parse($expiration_date)->addDays(365)->format("Y-m-d H:i:s");
    // }

    public static function divisor()
    {
        return 50;
    }

    public function setExpirationDateAttribute($value)
    {
        $this->attributes['expiration_date'] = \Carbon\Carbon::parse($value)->addDays(365);
    }

    public function testAddScore()
    {
        AlertMessages::smsAddScore($this->customer, $this->point);
        AlertMessages::lineAddScore($this->customer, $this->point);
        // if ($score) {
        //     return ["score" => $score, "status" => "success"];
        // }

        // return ["status" => "error"];

        //AHistoryPayed
    }

    public static function processing_point($amount = 0)
    {
        return floor($amount / self::divisor());
    }

    public static function addScore($customer, $amount, $can_refund = 0, $history_payed_id = null, $expiration_date = 365, $alert = true)
    {
        $score = new CustomerScore;
        $score->customer_id = $customer->id;
        $score->history_payed_id = $history_payed_id;
        $score->point = self::processing_point($amount); //$amount / self::divisor();
        $score->can_refund = $can_refund;
        $score->expiration_date = \Carbon\Carbon::now()->addDays($expiration_date);
        $score->save();

        if ($alert) {
            AlertMessages::smsAddScore($customer, $score->point);
            AlertMessages::lineAddScore($customer, $score->point);
        }

        if ($score) {
            return ["score" => $score, "status" => "success"];
        }

        return ["status" => "error"];

        //AHistoryPayed
    }

    public static function calculateScore($amount, $perScore = 50)
    {
        return $amount / $perScore;
        //AHistoryPayed
    }

    public static function useScore($customer_id, $point, $can_refund = 0, $history_payed_id = null)
    {
        $score = new CustomerScore;
        $score->customer_id = $customer_id;
        $score->history_payed_id = $history_payed_id;
        $score->point = -$point;
        $score->can_refund = $can_refund;
        $score->expiration_date = \Carbon\Carbon::now();
        $score->save();

        if ($score) {
            return ["score" => $score, "status" => "success"];
        }

        return ["score" => "error"];
    }

    public function customer()
    {
        return $this->belongsTo(ACustomer::class, "customer_id", "id");
    }

    public function historyPaid()
    {
        return $this->belongsTo(AHistoryPayed::class, "history_payed_id", "id");
    }
}
