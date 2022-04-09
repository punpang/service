<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Order\KsherPay;
use App\Order\AOrder;
use App\Order\AHistoryPayed;
use App\Order\AlertMessages;
use App\Linenotify;
use Illuminate\Http\Request;
use App\URL;
use App\Events\KsherPayEvent;

class KsherPayController extends Controller
{
    public function orderCreate()
    {
        // dd(request()->all());
        if (request("total_fee") < request("channel.minimum")) {
            return response()->json(
                ["message" => "จำนวนเงินต้องมากกว่า " . request("channel.minimum") . " บาท", "result" => "fail"],
                200
            );
        }

        $datas = [
            "mch_order_no" => request("mch_order_no") . "-" . KsherPay::generate_nonce_str(10),
            "total_fee" => round(request("total_fee"), 2) * 100,
            "fee_type" => "THB",
        ];

        $url_notify = URL::base() . '/api/callback/ksherPay';

        if (request("channel.payment_code") === "promptpayQR") {
            $datas["channel"] = request("channel.channel");
            $datas["notify_url"] = $url_notify;
            $ksher = KsherPay::native_pay($datas);
        } else if (
            request("channel.payment_code") === "eWallet" ||
            request("channel.payment_code") === "mobileBanking" && $datas["total_fee"] >= 20 ||
            request("channel.payment_code") === "debitCreditCard"
        ) {
            $datas["channel_list"] = request("channel.channel");
            $datas["mch_code"] = "Order NO." . KsherPay::explodeOrderId(request("mch_order_no"));
            $datas["mch_redirect_url"] = URL::base() . "/o/" . request("uuid");
            $datas["mch_redirect_url_fail"] = URL::base() . "/ksher/failed";
            $datas["product_name"] = "ปั้นแป้ง เบเกอรี่ ปราณบุรี";
            $datas["refer_url"] = "";
            $datas["lang"] = "th";
            $datas["logo"] = "https://drive.google.com/thumbnail?id=1EXAtHwE-JsZAAzb-qpSmoDWkZioZ5bmQ&sz=w800-h800";
            $datas["mch_notify_url"] = $url_notify;
            $ksher = KsherPay::gateway_pay($datas);
        }

        $ksherDecode = json_decode($ksher, true);

        $new_KsherPay = new KsherPay;
        $new_KsherPay->mch_order_no = $datas["mch_order_no"];
        $new_KsherPay->result;
        $new_KsherPay->amount = request("amount");
        $new_KsherPay->total_fee = request("total_fee");
        $new_KsherPay->save();

        // Linenotify::send($ksher);

        return $ksherDecode["data"];
    }

    public function orderQuery($mch_order_no)
    {
        $gateway_query_data = ['mch_order_no' => $mch_order_no];
        $gateway_query_response = KsherPay::order_query($gateway_query_data);
        // $gateway_query_array = json_decode($gateway_query_response, true);

        return $gateway_query_response;
    }

    public function callBack(Request $request)
    {
        // $response = request("data");
        // Linenotify::send(dd());
        // $data = [
        //     "code" => 0,
        //     "version" => "3.0.0",
        //     "status_code" => "",
        //     "msg" => "ok",
        //     "time_stamp" => "2022-01-27T16:52:31.479563+08:00",
        //     "status_msg" => "",
        //     "data" => [
        //         "openid" => "0323712689",
        //         "channel_order_no" => "220271552FI697342B004B092315522404",
        //         "operator_id" => "42248",
        //         "cash_fee_type" => "THB",
        //         "ksher_order_no" => "90020220127165205807217",
        //         "nonce_str" => "1wMwDHDbkaUlWNIEXRI5fkSTjShRIC06",
        //         "time_end" => "2022-01-27 15:52:30",
        //         "fee_type" => "THB",
        //         "attach" => "",
        //         "rate" => "0.000000",
        //         "result" => "SUCCESS",
        //         "total_fee" => 100,
        //         "appid" => "mch39290",
        //         "order_no" => "8529-1643273524359",
        //         "operation" => "NATIVE-PAY",
        //         "device_id" => "",
        //         "cash_fee" => 100,
        //         "channel" => "promptpay",
        //         "mch_order_no" => "8529-1643273524359"
        //     ],
        //     "sign" => "b2eac89e9603bef394445f302b5a5e2130a782c5567930f35549eb9db9bf89de42b639a16ea20ad0ed961dcc39bd6406b91b96ca3418bd2770afd27ce390af5f"
        // ];

        $response = json_decode($request->getContent(), true);

        // Linenotify::send($request->getContent());

        $mch_order_no = $response["data"]["mch_order_no"];

        $result = $response["data"]["result"];

        $orderID = KsherPay::explodeOrderId($mch_order_no);

        if ($result == "SUCCESS") {

            $KsherPay = KsherPay::updateStatusWhenCallbackSuccess($mch_order_no, $result);
            $amount = $KsherPay["ksher"]->amount;
            $result_order = AOrder::paymentByOrderID($orderID, $amount);

            if ($result_order["status"] == "success") {

                $result_aHistoryPayed = AHistoryPayed::paymentByOrderID($orderID, $amount, 3, $mch_order_no);

                if ($result_aHistoryPayed["status"] == "success") {
                    $KsherPayEven = [
                        "result" => "success",
                        "message" => "ชำระเงินสำเร็จ",
                        "event" => "KsherPayEvent",
                        "order_id" => $orderID
                    ];
                    broadcast(new KsherPayEvent($KsherPayEven));
                    // AlertMessages::smsPaymentOrder($result_order['order']->id, $amount);
                    // AlertMessages::linePaymentOrder($result_order['order'], $amount);
                    return ["result" => "SUCCESS", "msg" => "OK"];
                }
            }
        }

        $KsherPayEven = [
            "result" => "fail",
            "message" => "ชำระเงินไม่สำเร็จ",
            "event" => "KsherPayEvent",
            "order_id" => $orderID
        ];
        broadcast(new KsherPayEvent($KsherPayEven));
        AlertMessages::lineAlertGeneral("รับชำระเงินKSHER ไม่สำเร็จ #" . $mch_order_no);
        return ["result" => "fail", "msg" => "NO"];
    }

    public function checkStatusPaid(KsherPay $ksher)
    {
        if ($ksher->result == "create") {
            $message = [
                "title" => "ยังไม่ได้ชำระเงิน",
                "text" => "โปรดชำระเงิน",
                "icon" => "info"
            ];
        } else if ($ksher->result == "success") {
            $message = [
                "title" => "ชำระเงินสำเร็จ",
                "text" => "ขอบคุณที่ชำระเงิน",
                "icon" => "success"
            ];
        } else {
            $message = [
                "title" => "ชำระเงินไม่สำเร็จ",
                "text" => "โปรดชำระเงินอีกครั้ง หรือ ติดต่อทางร้าน 091-885-3402",
                "icon" => "error"
            ];
        }

        return response()->json(
            [
                'status' => "success",
                "message" => $message
            ],
            200
        );
    }
}
