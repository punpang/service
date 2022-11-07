<?php

namespace App\Order;

use App\Order\AOrder;
use App\Order\OrderDetailTemp;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ACustomer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'tel',
        'status_consent_condition'
    ];
    protected $guarded = [];

    protected $primaryKey = "id";

    protected $table = "a_customer";

    protected $connection = 'order';

    protected $hidden = ["created_at", "updated_at"];

    protected $appends = [
        "phone_format", "sum_diff_score"
    ];

    public function getDateGetAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->addYears(543)->format('d-m-Y');
    }

    public function getPhoneFormatAttribute()
    {
        return $this->tel[0] . $this->tel[1] . $this->tel[2] . "-" . $this->tel[3] . $this->tel[4] . $this->tel[5] . "-XXXX";
    }

    public function customerScores()
    {
        return $this->hasMany(CustomerScore::class, "customer_id", "id");
    }

    public function orders()
    {
        return $this->hasMany(AOrder::class, "id_customer", "id");
    }

    public function sumAvailableScore()
    {
        return $this->customerScores()
            ->where("expiration_date", ">=", \Carbon\Carbon::now())
            ->where("point", ">", 0)
            ->sum("point");
    }

    public function sumUnavailableScore()
    {
        return $this->customerScores()
            ->where("expiration_date", "<", \Carbon\Carbon::now())
            ->where("point", ">", 0)
            ->sum("point");
    }

    public function sumUsedScore()
    {
        return $this->customerScores()
            ->where("point", "<", 0)
            ->sum("point");
    }

    public function getsumDiffScoreAttribute()
    {
        return $this->sumDiffScore();
    }

    public function sumDiffScore()
    {
        return number_format($this->customerScores()->sum("point"), 0);
        // return number_format($this->sumAvailableScore() - $this->sumUnavailableScore(), 0);
        // $overUsedPoint = $this->sumUnavailableScore() - $this->sumUsedScore();
        // if ($overUsedPoint < 0) {
        //     return number_format($this->sumAvailableScore() + $overUsedPoint, 0);
        // } else {
        //     return number_format($this->sumAvailableScore(), 0);
        // }
    }

    public function temps()
    {
        return $this->hasMany(OrderDetailTemp::class, "customer_id", "id");
    }

    public function facebook()
    {
        return $this->hasOne(Facebook::class, "customer_id", "id");
    }

    public function line()
    {
        return $this->hasOne(Line::class, "customer_id", "id");
    }
}
