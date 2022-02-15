<?php

namespace App\Order;

use App\Order\AHistoryPayed;
use Illuminate\Database\Eloquent\Model;
use App\Order\AOrder;

class NoticeOfPaymentFromCustomer extends Model
{
    protected $table = "notice_of_payment_from_customers";

    protected $fillable = [
        "order_id",
        "amount",
        "ref",
        "src_name",
        "status"
    ];

    public function getCreatedAtAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->addYears(543)->format('d-m-Y H:i:s');
    }

    public function aOrder()
    {
        return $this->belongsTo(AOrder::class, "order_id", "id");
    }

    public function aHistoryPayedFindSelfID()
    {
        return $this->belongsTo(AHistoryPayed::class, "id", "notice_of_payment_from_customer_id");
    }

    public static function setCancel($notice)
    {
        $notice->status = 'cancel';
        $notice->ref  = NULL;
        $notice->save();

        if ($notice) {
            return [
                "status" => "success",
                "notice" => $notice
            ];
        }

        return [
            "status" => "error",
        ];
    }

    public static function setSuccess($notice, $amount, $ref)
    {
        $notice->amount = $amount;
        $notice->ref  = $ref;
        $notice->status = 'success';
        $notice->save();
        if ($notice) {
            return [
                "status" => "success",
                "notice" => $notice
            ];
        }

        return [
            "status" => "error",
        ];
    }

    public static function setCreate($notice)
    {
        $notice->status = 'create';
        $notice->ref  = NULL;
        $notice->save();
        if ($notice) {
            return [
                "status" => "success",
                "notice" => $notice
            ];
        }

        return [
            "status" => "error",
        ];
    }

    public static function setStart($notice, $amount, $ref)
    {
        $notice->amount = $amount;
        $notice->ref  = $ref;
        $notice->save();

        if ($notice) {
            return [
                "status" => "success",
                "notice" => $notice
            ];
        }

        return [
            "status" => "error",
        ];
    }
}
