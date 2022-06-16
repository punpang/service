<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\NoticeOfPaymentFromCustomer;
use App\Order\AOrder;
use App\Order\AHistoryPayed;
use App\Order\AlertMessages;
use App\URL;
// use App\Order\CustomerScore;

class NoticeOfPaymentFromCustomerController extends Controller
{
    public function createByUuid()
    {
        $order = AOrder::whereAuthOrder(request("uuid"))->first();
        if ($order) {
            $noticed = NoticeOfPaymentFromCustomer::create(
                [
                    "order_id" => $order->id,
                    "amount" => request("amount"),
                    "src_name" => request("src_name"),
                    "status" => "create"
                ]
            );
            if ($noticed) {
                AlertMessages::bothNoticeOfPaymentByCustomer($order->id, $noticed->amount);
                return [
                    "status" => "success",
                    "message" => "แจ้งชำระเงินสำเร็จ",
                    "data" => [
                        "order" => $order,
                        "noticed" => $noticed
                    ]
                ];
            }
        }
        return ["status" => "fail"];
    }

    public function getAllByAdmin()
    {
        $notices = NoticeOfPaymentFromCustomer::orderBy("status", "ASC")
            ->orderBy("created_at", "DESC")
            ->get();
        return $notices;
    }

    public function getCheckSlip($id)
    {
        $notice = NoticeOfPaymentFromCustomer::findOrFail($id);
        return [
            "notice" => $notice,
            "sumAll" => $notice->aOrder->sumAll(),
        ];
    }

    public function postCheckSlip()
    {
        // dd(request()->all());
        $checkRef = NoticeOfPaymentFromCustomer::where("ref", request("ref"))->first();
        $notice = NoticeOfPaymentFromCustomer::where("id", request("ntpfc.id"))->whereStatus("create")->first();

        if ($checkRef) {

            $setCancel = NoticeOfPaymentFromCustomer::setCancel($notice);
            if ($setCancel["status"] == "error") return AlertMessages::lineError("postCheckSlip");
            $notice = $setCancel["notice"];

            AlertMessages::smsPaymentOrderCancel($notice->aOrder->id, request("amount"));
            AlertMessages::linePaymentOrderCancel($notice->aOrder, request("amount"));

            return response()->json(
                [
                    "status" => "error",
                    "title" => "มีบางอย่างผิดพลาด",
                    "text" => "ref มีอยู่ในระบบแล้ว"
                ],
                200
            );
        }

        // if (request("amount") > $notice->aOrder->sumBalance()) {
        //     $pointOver = request("amount") - $notice->aOrder->sumBalance();
        //     $amount = request("amount") - $pointOver;
        // } else {
        //     $amount = request("amount");
        // }
        $amount = request("amount");

        $setStart = NoticeOfPaymentFromCustomer::setStart($notice, $amount, request("ref"));
        if ($setStart["status"] == "error") return AlertMessages::lineError("postCheckSlip");
        $notice = $setStart["notice"];

        if ($notice) {
            $order = AOrder::paymentByOrderID($notice->aOrder->id, $notice->amount);
            if ($order["status"] == "success") {
                $AHistoryPayed = AHistoryPayed::paymentByOrderID($notice->aOrder->id, $notice->amount, 2, null, $notice->id);
                if ($AHistoryPayed["status"] == "success") {
                    $setSuccess = NoticeOfPaymentFromCustomer::setSuccess($notice, $amount, request("ref"));
                    if ($setSuccess["status"] == "error") return AlertMessages::lineError("postCheckSlip");
                    $notice = $setSuccess["notice"];

                    // if (isset($pointOver)) {
                    //     CustomerScore::addScore($notice->aOrder->customer, $pointOver, 1, $AHistoryPayed["aHistoryPayed"]->id . "-overPaid");
                    // }
                    return response()->json(
                        [
                            "status" => "success",
                            "title" => "ผ่านการตรวจสอบ",
                            "text" => "รับชำระเงินเรียบร้อย"
                        ],
                        200
                    );
                } else {
                    $setCancel = NoticeOfPaymentFromCustomer::setCancel($notice);
                    if ($setCancel["status"] == "error") return AlertMessages::lineError("postCheckSlip");
                    $notice = $setCancel["notice"];

                    AlertMessages::smsPaymentOrderCancel($notice->aOrder->id, $notice->amount);
                    AlertMessages::linePaymentOrderCancel($notice->aOrder, $notice->amount);

                    return response()->json(
                        [
                            "status" => "error",
                            "title" => "ไม่ผ่านการตรวจสอบ",
                            "text" => "รายการนี้ซ้ำ"
                        ],
                        200
                    );
                }
            }
        }

        $setCreate = NoticeOfPaymentFromCustomer::setCancel($notice);
        if ($setCreate["status"] == "error") return AlertMessages::lineError("postCheckSlip");

        return response()->json(
            [
                "status" => "error",
                "title" => "มีบางอย่างผิดพลาด",
                "text" => "ปรับเป็นสถานะ : CREATE"
            ],
            200
        );
    }

    public function postUpdateSlip()
    {
        $notice = NoticeOfPaymentFromCustomer::where("id", request("ntpfc.id"))->whereStatus("success")->first();

        if (request("amount") > ($notice->aOrder->sumBalance() + $notice->amount)) {
            return response()->json(
                [
                    "status" => "error",
                    "title" => "มีบางอย่างผิดพลาด",
                    "text" => "ยอดเงินที่ชำระมากกว่ายอดคงเหลือ " . $notice->aOrder->sumBalance() . " บาท"
                ],
                200
            );
        }
        $amountOld = $notice->amount;

        $notice->aHistoryPayedFindSelfID->value = request("amount");
        $notice->aHistoryPayedFindSelfID->save();

        $notice->aHistoryPayedFindSelfID->customerScore->point = request("amount") / 50;
        $notice->aHistoryPayedFindSelfID->customerScore->save();

        // $historyOverPaid = $notice->aHistoryPayedFindSelfID->id . "-overPaid";
        // $pointOver = CustomerScore::where("history_payed_id", $historyOverPaid)->first();
        if (isset($pointOver)) {
            $pointOver->delete();
        }

        $notice->amount = request("amount");
        $notice->save();

        if ($amountOld != $notice->amount) {
            AlertMessages::smsPaymentOrderUpdate($notice->aOrder->id, $notice->amount, $amountOld);
        }
        AlertMessages::linePaymentOrderUpdate($notice->aOrder, $notice->amount, $amountOld);

        return response()->json([
            "status" => "success",
            "title" => "ปรับปรุงรายการ",
            "text" => "ปรับยอดชำระเงิน"
        ], 200);
    }

    public function postAppealSlip()
    {
        $notice = NoticeOfPaymentFromCustomer::where("id", request("ntpfc.id"))->whereStatus("cancel")->first();
        $notice->status = "create";
        $notice->save();

        AlertMessages::smsPaymentOrderAppeal($notice->aOrder->id);
        AlertMessages::linePaymentOrderAppeal($notice->aOrder);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "text" => "อุทธรณ์สำเร็จ"
        ], 200);
    }

    public function cronjobNoticePaymetByCustomer()
    {
        $notices = NoticeOfPaymentFromCustomer::whereStatus("create")->count();
        if ($notices > 0) {
            $link = URL::base() . "/manages/order/checkNoticeOfPaymentFromCustomer";
            $msgLine = 'รายการแจ้งชำระเงินจากลูกค้า ' . $notices . ' รายการ กำลังรอตรวจสอบ ' . $link;
            AlertMessages::LineAlertGeneral($msgLine);
            return $msgLine;
        }
        return;
    }
}
