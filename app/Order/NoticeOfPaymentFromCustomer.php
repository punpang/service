<?php

namespace App\Order;

use App\Helper;
use App\Linenotify;
use App\Order\AOrder;
use App\Order\AHistoryPayed;
use Illuminate\Database\Eloquent\Model;

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
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ["created_at_th", "ref_format"];


    // public function getCreatedAtAttribute($date)
    // {
    //     // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
    //     return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->addYears(543)->format('d-m-Y H:i:s');
    // }

    public function getCreatedAtThAttribute()
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        // return $this->created_at;
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->addYears(543)->format('d/m/y H:i:s');
    }

    public function getRefFormatAttribute()
    {
        if (is_null($this->ref)) {
            return $this->ref;
        }

        $ref = Helper::substr_slip_ref($this->ref);

        if ($ref == false) {
            return $this->ref;
        }
        return $ref;
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

    public static function setSuccessFromVerifySlip($qr_code_text, $notice)
    {
        $verify_slip = Helper::verify_slip($qr_code_text);
        // Linenotify::send('$verify_slip = Helper::verify_slip($result);');


        if ($verify_slip["date"] <= $notice->aOrder->created_at) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => วันที่สลิปไม่ถูกต้องเมืิ่อเทียบกับวันสร้างรายการ");
        }

        if ($verify_slip["amount"] > $notice->aOrder->sumBalance()) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => จำนวนเงินสลิปมากกว่ายอดที่ต้องชำระ");
        }

        if ($verify_slip["verify"] == false) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => สลิปไม่ผ่านการตรวจสอบ");
        }

        if (
            $verify_slip["verify"] &&
            $verify_slip["date"] > $notice->aOrder->created_at &&
            $verify_slip["amount"] <= $notice->aOrder->sumBalance()
        ) {
            NoticeOfPaymentFromCustomer::setSuccess($notice, $verify_slip["amount"], $notice->ref);
            AOrder::paymentByOrderID($notice->aOrder->id, $notice->amount);
            AHistoryPayed::paymentByOrderID($notice->aOrder->id, $notice->amount, 2, null, $notice->id);
            // AlertMessages::smsPaymentOrder($notice->order_id, $verify_slip["amount"]);
            AlertMessages::socialPaymentOrder($notice->aOrder, $verify_slip["amount"]);
            // AlertMessages::linePaymentOrder($notice->aOrder, $verify_slip["amount"]);
            return ["status" => true];
        }

        return ["status" => false];
    }

    public static function setSuccessFromVerifySlipV2($qr_code_text, $notice)
    {
        $verify_slip = Helper::verify_slip_v2($qr_code_text);
        // Linenotify::send('$verify_slip = Helper::verify_slip($result);');


        if ($verify_slip["date"] <= $notice->aOrder->created_at) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => วันที่สลิปไม่ถูกต้องเมืิ่อเทียบกับวันสร้างรายการ");
        }

        if ($verify_slip["amount"] > $notice->aOrder->sumBalance()) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => จำนวนเงินสลิปมากกว่ายอดที่ต้องชำระ");
        }

        if ($verify_slip["verify"] == false) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => สลิปไม่ผ่านการตรวจสอบ");
        }

        if (
            $verify_slip["verify"] &&
            $verify_slip["date"] > $notice->aOrder->created_at &&
            $verify_slip["amount"] <= $notice->aOrder->sumBalance()
        ) {
            NoticeOfPaymentFromCustomer::setSuccess($notice, $verify_slip["amount"], $notice->ref);
            AOrder::paymentByOrderID($notice->aOrder->id, $notice->amount);
            AHistoryPayed::paymentByOrderID($notice->aOrder->id, $notice->amount, 2, null, $notice->id);
            // AlertMessages::smsPaymentOrder($notice->order_id, $verify_slip["amount"]);
            AlertMessages::socialPaymentOrder($notice->aOrder, $verify_slip["amount"]);
            // AlertMessages::linePaymentOrder($notice->aOrder, $verify_slip["amount"]);
            return ["status" => true];
        }

        return ["status" => false];
    }

    public static function setSuccessFromVerifySlipV3($qr_code_text, $notice)
    {
        Linenotify::send("setSuccessFromVerifySlipV3 :: 1");

        $verify_slip = Helper::verify_slip_v3($qr_code_text);
        // Linenotify::send('$verify_slip = Helper::verify_slip($result);');


        if ($verify_slip["date"] <= $notice->aOrder->created_at) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => วันที่สลิปไม่ถูกต้องเมืิ่อเทียบกับวันสร้างรายการ");
        }

        if ($verify_slip["amount"] > $notice->aOrder->sumBalance()) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => จำนวนเงินสลิปมากกว่ายอดที่ต้องชำระ");
        }

        if ($verify_slip["verify"] == false) {
            Linenotify::send("ตรวจสอบสลิป => #" . $notice->aOrder->id . " => สลิปไม่ผ่านการตรวจสอบ");
        }

        if (
            $verify_slip["verify"] &&
            $verify_slip["date"] > $notice->aOrder->created_at &&
            $verify_slip["amount"] <= $notice->aOrder->sumBalance()
        ) {
            NoticeOfPaymentFromCustomer::setSuccess($notice, $verify_slip["amount"], $notice->ref);
            AOrder::paymentByOrderID($notice->aOrder->id, $notice->amount);
            AHistoryPayed::paymentByOrderID($notice->aOrder->id, $notice->amount, 2, null, $notice->id);
            // AlertMessages::smsPaymentOrder($notice->order_id, $verify_slip["amount"]);
            AlertMessages::socialPaymentOrder($notice->aOrder, $verify_slip["amount"]);
            // AlertMessages::linePaymentOrder($notice->aOrder, $verify_slip["amount"]);
            return ["status" => true];
        }

        return ["status" => false];
    }
}
