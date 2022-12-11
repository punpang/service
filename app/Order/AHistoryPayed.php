<?php

namespace App\order;

use Illuminate\Database\Eloquent\Model;
use App\Order\ChannelPayment;
use App\Order\AOrder;
use App\Order\CustomerScore;
use App\Order\NoticeOfPaymentFromCustomer;
use App\Order\KsherPay;
use App\Order\AlertMessages;

class AHistoryPayed extends Model
{
    protected $table = "a_history_payed";
    protected $connection = "order";
    public $timestamps = false;

    protected $primaryKey = "id";
    protected $hidden = ['created_at', 'updated_at'];


    protected $fillable = [
        'value',
        'channel_payment_id',
        "user",
        "list",
        "billno",
        "date_time"
    ];

    public function getDateTimeAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->addYears(543)->format('d-m-Y H:i:s');
    }

    public function channelPayment()
    {
        return $this->belongsTo(ChannelPayment::class, "channel_payment_id", "id");
    }

    public function order()
    {
        return $this->belongsTo(AOrder::class, "id_order", "id");
    }

    public function customerScore()
    {
        return $this->hasOne(CustomerScore::class, "history_payed_id", "id");
    }

    public function newCustomerScore()
    {
        $customerScore = new CustomerScore;
        return $customerScore;
    }

    public function ntpfc()
    {
        return $this->belongsTo(NoticeOfPaymentFromCustomer::class, "notice_of_payment_from_customer_id", "id");
    }

    public function ksherPay()
    {
        return $this->belongsTo(KsherPay::class, "mch_order_no_of_ksher_pay", "mch_order_no");
    }

    public static  function paymentByOrderID(
        $order_id,
        $amount,
        $channel_payment_id,
        $mch_order_no_of_ksher_pay = null,
        $notice_of_payment_from_customer_id = null
    ) {
        // return "success";
        if ($mch_order_no_of_ksher_pay != null) {
            $check = AHistoryPayed::where("mch_order_no_of_ksher_pay", $mch_order_no_of_ksher_pay)->first();
            if ($check) {
                return ["status" => "fail"];
            }
        }

        if ($notice_of_payment_from_customer_id != null) {
            $check = AHistoryPayed::where("notice_of_payment_from_customer_id", $notice_of_payment_from_customer_id)->first();
            if ($check) {
                return ["status" => "fail"];
            }
        }

        $aHistoryPayed = new AHistoryPayed;
        $aHistoryPayed->id_order = $order_id;
        $aHistoryPayed->user = "new_system";
        $aHistoryPayed->list = 9;
        $aHistoryPayed->value = $amount;
        $aHistoryPayed->billno = 1;
        $aHistoryPayed->date_time = \Carbon\Carbon::now();
        $aHistoryPayed->channel_payment_id = $channel_payment_id;
        $aHistoryPayed->mch_order_no_of_ksher_pay = $mch_order_no_of_ksher_pay;
        $aHistoryPayed->notice_of_payment_from_customer_id = $notice_of_payment_from_customer_id;
        $aHistoryPayed->save();

        AlertMessages::smsPaymentOrder($aHistoryPayed->order->id, $amount);
        //AlertMessages::socialPaymentOrder($aHistoryPayed->order,$amount);
        AlertMessages::linePaymentOrder($aHistoryPayed->order, $amount);

        // $point = CustomerScore::calculateScore($amount);
        // CustomerScore::addScore($aHistoryPayed->order->customer, $amount, 0, $aHistoryPayed->id);


        if ($aHistoryPayed) {
            return ["aHistoryPayed" => $aHistoryPayed, "status" => "success"];
        } else {
            return ["status" => "fail"];
        }

        return ["status" => "fail"];
    }
}
