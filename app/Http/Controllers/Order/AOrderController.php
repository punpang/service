<?php

namespace App\Http\Controllers\Order;

use Bitly;
use App\URL;
use App\MSms;
use App\Helper;
use App\Linenotify;
use App\Order\Line;
use App\Order\AOrder;
use App\Order\Facebook;
use App\Order\OrderTemp;
use App\Order\OrderDetail;
use App\Order\StoreDayOff;
use Illuminate\Support\Str;
// use App\Order\ImageFromCustomer;
use App\Order\AHistoryPayed;
use App\Order\AlertMessages;
use App\Order\CustomerScore;
// use App\Order\KsherChannelPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class AOrderController extends Controller
{
    public function checkDateTimeGet()
    {
        // dd(request()->all());
        // 20/01/2023 <= 21/01/2023 /
        // 22/02/2023 >= 20/01/2023 /
        $time_get =  request("timeGet") . ":00";
        // 09.00 <=  15.00 /
        // 14.00 >=  15.00 *
        $day_off = StoreDayOff::where("start_date", "<=", request("dateGet"))
            ->where("end_date", ">=", request("dateGet"))
            ->where("start_time", "<=", $time_get)
            ->where("end_time", ">=", $time_get)
            ->first();

        if (!is_null($day_off)) {
            if ($day_off->start_time == "00:00:00" && $day_off->end_time == "23:59:59") {
                $message = "ร้านหยุดให้บริการ $day_off->start_date_th - $day_off->end_date_th";
            } else {
                $message = "ร้านหยุดให้บริการ $day_off->start_date_th $day_off->start_time - $day_off->end_time น.";
            }

            return [
                "status" => "error",
                "message" => $message
            ];
        }


        // $orders = AOrder::whereDateGet(request("dateGet"))
        //     ->whereTimeGet($time_get)
        //     ->whereIn("status", [0, 1, 2, 3, 4, 5, 6, 7])
        //     // ->select("id","")
        //     ->get()
        //     ->makeHidden(['sum_all']);


        $dateGet = request("dateGet");
        $orders = OrderDetail::whereHas("aOrder", function ($q) use ($dateGet, $time_get) {
            $q->where("date_get", $dateGet)
                ->where("time_get", $time_get)
                ->where("status", "<", "8");
        })
            ->with(
                "aOrder",
                "aOrder.orderDeliveryService",
                "aOrder.aStatus",
                "aPrice.googleImage",
                "addOns.productAddOn.goodsAddOn",
                "imageFromCustomers.googleImage",
                "productPrototypes.googleImage"
            )
            ->get();


        // ->whereHas("aOrder", function ($q) use ($request) {
        //     $q->where("date_get", $request->get("date_get"));
        //     $q->where("status", "<", "8");
        // })
        return $orders;
    }

    public function sumOrderToday()
    {
        return AOrder::where([
            ["date_get", now()->format("Y-m-d")],
            ["status", "9"]
        ])->count();
    }

    public function waitConfirmFromCustomer()
    {
        $orders = AOrder::where([
            ["date_get", now()->addDays(1)->format("Y-m-d")],
            ["status", 2]
        ])->get();

        $msgLine = "รายการพรุ่งนี้ รอชำระเงิน " . $orders->count() . " รายการ";
        Linenotify::send($msgLine);

        foreach ($orders as $order) {
            $date_get = \Carbon\Carbon::parse($order->date_get)->addYears(543)->format("d-m-Y");
            $msgLine = "แจ้งชำระเงิน -> #" . $order->id . " รับ " . $date_get . " " . $order->time_get . " น.";
            $msgSms = "ปั้นแป้ง สวัสดีค่ะ [อัตโนมัติ] โปรดชำระมัดจำ เลขคำสั่งซื้อ #" . $order->id . " รับ " . $date_get . " " . $order->time_get . " น. ของคุณ เพื่อยืนยันการสั่งซื้อ และรับสินค้าได้ตามเวลานัดที่ท่านแจ้งไว้ โปรดชำระก่อน 14.00 น.";
            Linenotify::send($msgLine);
            MSms::Sms($order->customer->tel, $msgSms);
        }

        return "success";
    }

    public function orderToDay()
    {
        $waitConfirm = AOrder::where([
            ["date_get", now()->format("Y-m-d")],
            ["status", 2]
        ])->count();

        $confirm = AOrder::where("date_get", now()->format("Y-m-d"))
            ->whereIn("status", [3, 4, 5])->count();

        $msgLine = "สั่งซื้อสำเร็จ ( " . $confirm . " ) | รอยืนยัน ( " . $waitConfirm . " )";
        Linenotify::send($msgLine);

        return "success";
    }

    public function sumDaily()
    {
        $orders = AOrder::where([
            ["date_get", now()->format("Y-m-d")],
            ["status", 9]
        ])->get();

        $msgLine = "ยอดขายวันนี้ โดยประมาณ ฿" . number_format($orders->sum("total"), 2)  . " จากทั้งหมด " . $orders->count() . " รายการ";
        Linenotify::send($msgLine);

        return "success";
    }

    public function sumWeekly()
    {
        $toDay = now()->format("Y-m-d");
        $fromDay = now()->subDays(6)->format("Y-m-d");

        $orders = AOrder::whereBetween("date_get", [$fromDay, $toDay])
            ->where("status", 9)
            ->get();

        $msgLine = "ยอดขายประจำสัปดาห์ (" . now()->subDays(6)->format("d") . " - " . now()->format("d-m-Y") . ") ฿" . number_format($orders->sum("total"), 2) . " ( " . $orders->count() . " รายการ )";
        Linenotify::send($msgLine);

        return "success";
    }

    public function sumMonthly()
    {
        $month = now()->subMonths(1)->format("m");
        $year = now()->format("Y");

        $orders = AOrder::whereMonth("date_get", $month)
            ->whereYear("date_get", $year)
            ->where("status", 9)
            ->get();

        $msgLine = "ยอดขายประจำเดือน " . $month . " ฿" . number_format($orders->sum("total"), 2) . " ( " . $orders->count() . " รายการ )";
        Linenotify::send($msgLine);

        return "success";
    }

    public function sumAnnual()
    {
        $year = now()->subYears(1)->format("Y");

        $orders = AOrder::whereYear("date_get", $year)
            ->where("status", 9)
            ->get();

        $msgLine = "ยอดขายประจำปี " . $year . " ฿" . number_format($orders->sum("total"), 2) . " ( " . $orders->count() . " รายการ )";
        Linenotify::send($msgLine);

        return "success";
    }

    public function fetchByUUID($uuid)
    {
        $order = AOrder::whereAuthOrder($uuid)
            ->where("date_get", ">=", \Carbon\Carbon::now()->format("Y-m-d"))
            ->with(
                "customer",
                // "am1",
                // "am2",
                // "am3",
                // "am4",
                "aStatus",
                "ntpfcsForCustomer",
                "orderDetails.aPrice.googleImage",
                "orderDetails.productPrototypes.googleImage",
                "orderDetails.imageFromCustomers.googleImage",
                "orderDetails.imageGoodsReviewToCustomers.googleImage",
                "orderDetails.MoneyServices.category_money_service",
                "orderDeliveryService",
                "posOrders.posGoods"
            )
            ->with("orderDetails.addOns.productAddOn.goodsAddOn")
            ->first();

        return response()->json([
            "order" => $order,
            "status" => "success",
            // "sumAll" => $order->sumAll(),
            // "setNameGoods" => $order->setNameGoods()
        ]);
    }

    public function uploadImagesByUUID(Request $request)
    {

        $detail = OrderDetail::whereHas("aOrder", function ($query) use ($request) {
            return $query->where("auth_order", $request->uuid);
        })->findOrFail($request->order_detail_id);

        $images = [];
        foreach ($request->imagesData as $image) {
            $images[] = [
                "google_image_id" => $image["id"]
            ];
        }

        $detail->imageFromCustomers()->createMany($images);

        return response()->json([
            "status" => "success"
        ], 200);
    }

    public function removeImageIdByUUID(Request $request)
    {
        $detail = OrderDetail::whereHas("aOrder", function ($query) use ($request) {
            return $query->where("auth_order", $request->uuid);
        })->findOrFail($request->order_detail_id);

        $imageFromCustomer = $detail->imageFromCustomers()->where("id", $request->image_from_customer_id)->first();
        Storage::cloud()->delete($imageFromCustomer->googleImage->src_name);
        $imageFromCustomer->delete();

        return response()->json([
            "status" => "success"
        ], 200);
    }

    public function getOrderByID($order_id)
    {

        // $order = AOrder::with("orderDetailsNull")->findOrFail($order_id);
        // return $order;
        $order = AOrder::with(
            "customer.facebook",
            "customer.line",
            "OrderChannel",
            // "am1",
            // "am2",
            // "am3",
            // "am4",
            "aStatus",
            "aHistoryPayed.channelPayment",
            "aHistoryPayed.ntpfc",
            "aHistoryPayed.ksherPay",
            "orderDetails.aPrice.googleImage",
            // "orderDetailsOnlyTrashed",
            "orderDetails.productPrototypes.googleImage",
            "orderDetails.imageForMenus.googleImage",
            "orderDetails.imageFromCustomers.googleImage",
            "orderDetails.imageGoodsReviewToCustomers.googleImage",
            "orderDetails.orderTags.tag",
            "orderDeliveryService",
            "orderDetails.MoneyServices.category_money_service",
            "adjustExcessPayments",
            "posOrders.posGoods",
            "orderDetails.multiCakes.aPrice",
            "couponUsed.coupon"

        )
            ->with("orderDetails.addOns.productAddOn.goodsAddOn")

            ->findOrFail($order_id);

        // $detail = OrderDetail::whereHas("aOrder", function ($query) use ($request) {
        //     return $query->where("auth_order", $request->uuid);
        // })->findOrFail($request->order_detail_id);



        // ->with(
        //     "customer",

        //     "aStatus",
        //     "imageFromCustomers.googleImage",
        //     "ntpfcsForCustomer",
        //     "orderDetails.aPrice",

        // )
        // ->with("orderDetails.addOns.productAddOn.goodsAddOn")
        // ->first();


        // dd($order->totalGoods());
        // if ($order->balance == 0 && $order->deposit == 0) {
        //     $order->balance = $order->sumBalance();
        //     $order->save();
        // }

        if ($order->sumMoneyCustomer() > 0 || $order->orderDeliveryService) {
            $order->update(["status_full_payment" => 1]);
        }

        return response()->json([
            "order" => $order,

            // "sumAll" => $order->sumAll(),
            // "setNameGoods" => $order->setNameGoods()
        ], 200);
    }

    public function promptPayQrCodeSCB()
    {

        // dd(request()->all());

        // $first = "000201010212306";
        // $text = request("order_id");
        // $countText = strlen($text);
        // $second = $countText + 2;
        // $three = "0016A00000067701011201150107536000102860215014000004895363030";
        // $four = "5802TH540";
        // $amount = number_format(request("amount"), 2, '.', '');
        // $countAmount = strlen($amount); //3
        // $last = "53037646220071600000000007066306304";

        // $first = "000201010212307";
        // $text = "PUNPANGPRANBURI";
        // $countText = "15";
        // $second = "7";
        // $three = "0016A0000006770101120115010753600010286021501400000489536303";
        // $four = "5802TH540";
        // $amount = number_format(request("amount"), 2, '.', '');
        // $countAmount = strlen($amount); //3
        // $last = "53037646220071600000000007066306304";
        // $code = $first . $second . $three . $countText . $text . $four . $countAmount . $amount . $last;


        $first = "00020101021230770016A000000677010112011501075360001028602150140000048953630315PUNPANGPRANBURI5802TH540";
        $amount = number_format(request("amount"), 2, '.', '');
        $countAmount = strlen($amount); //3
        $last = "53037646220071600000000007066306304";

        $code = $first . $countAmount . $amount . $last;

        // $cofer = "00020101021230640016A000000677010112011501075360001028602150140000048953630302995802TH54042.0053037646220071600000000007066306304";
        $xFFFF = dechex(Helper::CRC16Normal($code));

        $full = Str::upper($code . $xFFFF);

        return response()->json(
            [
                "full" => $full,
                "xFFFF" => $xFFFF,
            ]
        );

        // 000201010212306 7 0016A00000067701011201150107536000102860215014000004895363030 5 99999 5802TH540 7 2000.00 53037646220071600000000007066306304 89C9
        // 000201010212306 3 0016A00000067701011201150107536000102860215014000004895363030 1     9 5802TH540 4    2.00 53037646220071600000000007066306304 2445
        // 000201010212306 4 0016A00000067701011201150107536000102860215014000004895363030 2    99 5802TH540 4    2.00 53037646220071600000000007066306304 88FC
        // 000201010212306 4 0016A00000067701011201150107536000102860215014000004895363030 2    99 42.00                        53037646220071600000000007066306304 88fc
        // 00020101021230770016A000000677010112011501075360001028602150140000048953630315PUNPANGPRANBURI5802TH540 6200.00 53037646220071600000000007066306304 57F5
    }

    public function paymentByOrderID()
    {
        // ----$order = AOrder::find($request->orderID);
        // $order->testPaymentByOrderID();
        // ----$order->testPaymentByOrderID($request);
        // ->historyPaid()->create([
        //     'value' => $request->amount,
        //     'channel_payment_id' => $request->channel["id"],
        //     "user" => "new_system",
        //     "list" => 9,
        //     "billno" => 1,
        //     "date_time" => \Carbon\Carbon::now()
        // ])->customerScore()->create([
        //     "customer_id" => $order->customer->id,
        //     "point" => $request->amount,
        //     "expiration_date" => \Carbon\Carbon::now()
        // ])->testAddScore();

        // ---- return $order;
        // $order->where("status", "<=", 2)->update([
        //     "status" => 3
        // ]);

        // $order->historyPaid()->create([
        //     'value' => $request->amount,
        //     'channel_payment_id' => $request->channel["id"],
        //     "user" => "new_system",
        //     "list" => 9,
        //     "billno" => 1,
        //     "date_time" => \Carbon\Carbon::now()
        // ]);

        // $historyPaid = $order->historyPaid()->orderBy("id", "DESC")->first();
        // $historyPaid->customerScore()->create([
        //     "customer_id" => $order->customer->id,
        //     "point" => $request->amount,
        //     "expiration_date" => \Carbon\Carbon::now()
        // ]);

        // $customerScore = $order->historyPaid()->orderBy("id", "DESC")->first()->customerScore;

        // AlertMessages::smsPaymentOrder($order->id, $request->amount);
        // AlertMessages::smsAddScore($order->customer, $customerScore->point);
        // AlertMessages::linePaymentOrder($order, $request->amount);
        // AlertMessages::lineAddScore($order->customer, $customerScore->point);

        // return $order;

        $order = AOrder::paymentByOrderID(request("orderID"), request("amount"));
        if ($order["status"] == "success") {
            // dd(request()->all());
            $history = AHistoryPayed::paymentByOrderID(
                request("orderID"),
                request("amount"),
                request("channel.id")
            );
            if ($history["status"] == "success") {
                AlertMessages::socialPaymentOrder($order["order"], request("amount"), request("getGoods"));
                if (request("getGoods")) {
                    $this->pickUpOrderByID(request("orderID"), request("is_add_score"));
                    return response()->json([
                        "message" => "ชำระเงินสำเร็จและรับสินค้าเรียบร้อย",
                        "result" => "success",
                        "msg" => "OK"
                    ], 200);
                }
                return response()->json([
                    "message" => "ชำระเงินสำเร็จ",
                    "result" => "success",
                    "msg" => "OK"
                ], 200);
            }
        }

        ///
        $order = AOrder::find(request("orderID"));

        if ($order->sumTASC() !== $order->sumDeposited() + $order->sumBalance()) {
            return response()->json([
                "message" => "จำนวนเงินไม่ถูกต้อง"
            ], 201);
        }

        if ($order->auth_order == null) {
            $order->auth_order = Str::uuid();
        }

        $order->deposit = $order->sumDeposited() + request("amount");
        $order->balance = $order->sumBalance() - request("amount");

        if ($order->status <= 4) {
            $order->status = 3;
        }

        $order->save();

        //
        $aHistoryPayed = new AHistoryPayed;
        $aHistoryPayed->id_order = $order->id;
        $aHistoryPayed->user = "new_system";
        $aHistoryPayed->list = 9;
        $aHistoryPayed->value = request("amount");
        $aHistoryPayed->billno = 1;
        $aHistoryPayed->date_time = \Carbon\Carbon::now();
        $aHistoryPayed->channel_payment_id = request("channel.id");
        $aHistoryPayed->save();

        $nbfm_amount = number_format(request("amount"), 2);
        $msgLine = 'รับชำระเงิน -> #' . $order->id . ' จำนวน ' . $nbfm_amount . ' บาท ';
        Linenotify::send($msgLine);



        $link = URL::base() . "/o/" . $order->auth_order;
        $bitly = Bitly::getUrl($link);
        $msgSms = 'ขอบคุณที่ชำระเงิน จำนวน ' . $nbfm_amount  . ' บาท หมายเลขคำสั่งซื้อ #' . $order->id . ' รายละเอียดรายการสั่งซื้อคลิกลิงก์ [ ' . $bitly . ' ]\n\nวัน-เวลานัดรับสินค้า\n' . $order->dateGetTimeFormat();
        MSms::Sms($order->customer->tel, $msgSms, request("alertSMS"));
    }

    public function pickUpOrderByID($order_id, $is_add_score = true)
    {
        $order = AOrder::findOrFail($order_id);

        if ($order->status != 8) {
            return response()->json(
                [
                    "result" => "error",
                    "msg" => "ok",
                    "message" => 'ไม่อยู่ในสถานะ "เตรียมสินค้า"'
                ],
                201
            );
        }

        $order->status = 9;
        $order->save();

        // $msgSms = 'ท่านเข้ารับสินค้าแล้ว หมายเลขคำสั่งซื้อ #' . $order->id . ' หากท่านยังไม่ได้รับสินค้า​ โปรดแจ้งทางร้านทันที โทร. 091-885-3402 หรือ [ https://m.me/punpangpranburi ]';
        //$msgLine = 'ส่งมอบสินค้าแล้ว -> #' . $order->id;

        //Linenotify::send($msgLine);
        //MSms::Sms($order->customer->tel, $msgSms);

        AlertMessages::linePickUpGoods($order);
        AlertMessages::smsPickUpGoods($order);

        if ($is_add_score) {
            CustomerScore::addScore($order->customer, $order->sumForScore());
        }

        return response()->json([
            "message" => "รับสินค้าเรียบร้อย",
            "result" => "success",
            "msg" => "OK"
        ], 200);
    }

    public function alertPaymentByOrderID()
    {

        $order = AOrder::findOrFail(request("orderID"));
        $payment_deadline = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', request("payment_deadline"))->subYears(543)->format('Y-m-d H:i:s');

        if ($order->auth_order == null) {
            $order->auth_order = Str::uuid();
        }

        $order->payment_deadline = $payment_deadline;
        $order->status_full_payment = request("status_full_payment");

        if (
            $order->sumMoneyCustomer() > 0
            || $order->orderDeliveryService
        ) {
            $order->status_full_payment = 1;
        }

        $order->save();

        if ($order) {
            // $bitly = AOrder::genlinkUuid($order->id);
            AlertMessages::lineAlertPayment($order);
            AlertMessages::smsAlertPayment($order);


            //             $message = "
            // 📌 หมายเลขคำสั่งซื้อ #" . $order->id . "
            // ---------------------------
            // 📌 ข้อมูลลูกค้า
            // คุณ " . $order->customer->name . "
            // เบอร์โทรศัพท์ " . $order->customer->tel . "
            // ---------------------------
            // 📌 วัน-เวลานัดรับสินค้า
            // " . $order->date_time_get_th . " น.
            // ---------------------------
            // 📌 ยอดรวมทั้งหมด " . number_format($order->sumTASC(), 2) . " บาท
            // 📌 ยอดชำระแล้ว " . number_format($order->sumDeposited(), 2) . " บาท
            // ---------------------------
            // 📌 ยอดคงเหลือ " . number_format($order->sumBalance(), 2) . " บาท
            // ---------------------------
            // 📌 โปรดชำระเงินภายใน
            // " . $order->payment_deadline_th . " น.
            // ---------------------------
            // หลังจากลูกค้าชำระเงินแล้ว
            // ทางร้านสงวนสิทธิ์ลูกค้าตรวจสอบรายการสั่งซื้อแล้ว";
            //             Facebook::send_reply_message(
            //                 $order,
            //                 $message
            //             );


            // $payload_genarate_qrcode_promtpay_to_facebook = [
            //     "keyword" => "genarate_qrcode_promtpay_to_facebook",
            //     "order_id" => $order->id,
            // ];
            // Facebook::send_reply_image($order, "https://lh3.googleusercontent.com/d/1MhRh4V6olX8pAtWU5kGPlLLjV9HOatCv");
            //1MhRh4V6olX8pAtWU5kGPlLLjV9HOatCv

            AOrder::summaryOfOrderDetails($order->id, true);

            $payload_send_postback = [
                [
                    "title" => "สรุปรายการสั่งซื้อและชำระเงิน",
                    "subtitle" => "โปรดศึกษาเงื่อนไขก่อนกดปุ่ม -> ถูกต้อง, เลขที่บัญชี",
                    "buttons" => [
                        [
                            "title" => "รายละเอียด",
                            "url" => $order->link_for_customer,
                            "type" => "web_url"
                        ],
                        [
                            "title" => "ถูกต้อง ,เลขที่บัญชี",
                            "payload" => json_encode(
                                [
                                    "keyword" => "account_number_and_slip_attachment_link",
                                    "order_id" => $order->id,
                                ]
                            ),
                            "type" => "postback"
                        ],
                    ],

                ]
            ];

            Facebook::send_postback(
                $order,
                $payload_send_postback
            );

            // $payload = [
            //     "keyword" => "not_confirm_payment",
            //     "order_id" => $order->id,
            //     "link_for_customer" => $order->link_for_customer
            // ];
            // [
            //     "title" => "ไม่สะดวกชำระเงิน",
            //     "payload" => json_encode($payload),
            //     "type" => "postback"
            // ],


            // $ksher = KsherChannelPayment::where("payment_code", "promptpayQR")
            //     ->where("status_use", 1)
            //     ->where("maximum", ">=", $order->sumTASC())
            //     ->WhereDoesntHave("ksherDayOff", function ($query) {
            //         return $query->where("day_off", \Carbon\Carbon::now()->format('Y-m-d'));
            //     })->first();

            // if (
            //     $ksher &&
            //     // $order->status < 3 &&
            //     $order->payment_deadline >= now()->format('Y-m-d H:i:s') &&
            //     $order->sumMoneyCustomer() == 0
            // ) {
            //     //Facebook::send_reply_image($order, "https://lh3.googleusercontent.com/d/1qJvIUnRVopU7YLDKNQh6KCQZN8lss5uL");
            //     $create_qr_code_promptpay_send_postback = [
            //         [
            //             "title" => "สแกนจ่าย QRพร้อมเพย์ สะดวก รวดเร็ว ไม่ต้องส่งสลิป",
            //             "subtitle" => "ค่าธรรมเนียม +$ksher->fee_value บาท",
            //             "buttons" => [
            //                 [
            //                     "title" => "สแกนจ่าย QRพร้อมเพย์",
            //                     "payload" => json_encode(
            //                         [
            //                             "keyword" => "genarate_qrcode_promtpay_to_facebook",
            //                             "order_id" => $order->id,
            //                         ]
            //                     ),
            //                     "type" => "postback"
            //                 ],
            //             ]
            //         ]
            //     ];
            //     Facebook::send_postback(
            //         $order,
            //         $create_qr_code_promptpay_send_postback
            //     );
            // }

            Line::flex_alert_payment($order);

            return response()->json([
                "status" => "successs",
                "title" => "แจ้งเตือนสำเร็จ",
                "text" => "โปรดคัดลอกรายละเอียดและส่งต่อให้ลูกค้า"
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "title" => "ไม่สำเร็จ",
                "text" => "ไม่สามารถแจ้งเตือนได้ในขณะนี้"
            ], 200);
        }


        // dd($payment_deadline, $order->dateGetTime(), $payment_deadline < $order->date_get . " " . $order->time_get . ".00");
    }

    public function alertPaymentExtendTimeByOrderID(AOrder $order)
    {
        // dd($order);
        $payment_deadline = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', request("payment_deadline"))->subYears(543)->format('Y-m-d H:i:s');

        $order->payment_deadline = $payment_deadline;
        $order->status_full_payment = request("status_full_payment");

        if (
            $order->sumMoneyCustomer() > 0
            || $order->orderDeliveryService
        ) {
            $order->status_full_payment = 1;
        }

        $order->save();

        Facebook::text_account_number_and_slip_attachment_link($order);

        return response()->json([
            "status" => "successs",
            "title" => "ขยายเวลาชำระเงินสำเร็จ",
            "text" => "โปรดคัดลอกรายละเอียดและส่งต่อให้ลูกค้า"
        ], 200);
    }

    public function updateRatingByUuid()
    {
        // $order = AOrder::whereAuthOrder(request("uuid"))->first();
        // $order->rating = request("rating");
        // $order->save();

        $order = AOrder::whereAuthOrder(request("uuid"))->first();

        if ($order->rating == 0) {
            CustomerScore::addScore($order->customer, 100);
        }

        $order->rating = request("rating");
        $order->save();

        return response()->json([
            "status" => "success",
            "title" => "อัปเดทคะแนนเรียบร้อย",
            "text" => "ขอบคุณที่ร่วมให้คะแนนทางร้านค่ะ"
        ], 200);
    }

    public function addGoodsCake(AOrder $order, Request $request)
    {

        $order->orderDetail()->create([
            "a_price_id" => $request->a_price["id"],
            "price" => $request->a_price["price"],
            "message" => $request->a_price["message"],
            "detail" => $request->a_price["detail"]
        ]);

        if ($order->orderDetail->aPrice->m3 == 2) {
            $order->orderDetail->status_upload_images_from_customer = 1;
            $order->orderDetail->save();
        }

        return response()->json([
            "status" => "success",
            "message" => "สร้างสินค้าใหม่เรียบร้อย (CAKE)"
        ], 200);
    }

    public function newOrder(Request $request)
    {

        $orderTemp = OrderTemp::whereId($request->temp["id"])->first();
        // dd($orderTemp->temp->channel);


        $order = AOrder::create(
            [
                "id_customer" => $orderTemp->customer_id,
                "date_get" => $orderTemp->temp->dateTimeGet->dateGet,
                "time_get" => $orderTemp->temp->dateTimeGet->timeGet,
                "channel" => $orderTemp->temp->channel,
                "status" => 1,
                "date_order" => \Carbon\Carbon::now()->format("Y-m-d H:i:s"),
                "auth_order" => Str::uuid(),
            ]
        );
        // "date_order" => \Carbon\Carbon::now()->format("Y-m-d H:i:s"),
        // return $order;
        // ->makeHidden(["sum_all"]);

        // $orderDetailTemps = $orderTemp->orderDetailTemps;
        // foreach ($orderDetailTemps as $orderDetailTemp) {

        //     if (isset($orderDetailTemp->temp->add_ons)) {
        //         $add_ons = [];
        //         foreach ($orderDetailTemp->temp->add_ons as $add_on) {
        //             $add_ons[] = [
        //                 "product_add_on_id" => $add_on->id,
        //                 "price" => $add_on->price,
        //             ];
        //         }
        //     }

        //     $order->orderDetail()->create([
        //         "a_price_id" => $orderDetailTemp->temp->a_price->id,
        //         "price" => $orderDetailTemp->temp->a_price->price,
        //         "message" => $orderDetailTemp->temp->message,
        //         "detail" => $orderDetailTemp->temp->detail
        //     ]);

        //     if (isset($orderDetailTemp->temp->add_ons)) {
        //         $add_ons = [];
        //         foreach ($orderDetailTemp->temp->add_ons as $add_on) {
        //             $add_ons[] = [
        //                 "product_add_on_id" => $add_on->id,
        //                 "price" => $add_on->price,
        //             ];
        //         }
        //         $order->addOn()->createMany(
        //             $add_ons
        //         );
        //     }

        //     $orderDetailTemp->delete();
        // }
        $orderTemp->delete();

        return response()->json([
            "order_id" => $order->id,
            "status" => "success",
            "message" => "สร้างรายการสั่งซื้อสำเร็จ"
        ], 200);
    }

    public function changeCustomer(AOrder $order, Request $request)
    {
        $order->update(["id_customer" => $request->customer_id]);

        return response()->json([
            "status" => "success",
            "message" => "เปลี่ยนลูกค้าสำเร็จ"
        ], 200);
    }

    public function changeDateTimeGet(AOrder $order, Request $request)
    {

        $order->update([
            "date_get" => $request->date_time_get["date_get"],
            "time_get" => $request->date_time_get["time_get"]
        ]);

        AlertMessages::lineChangeDateTimeGet($order);
        AlertMessages::smsChangeDateTimeGet($order, $request->alert_sms);
        AlertMessages::socialChangeDateTimeGet($order, $request->alert_sms);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success",
            "message" => "เปลี่ยนวัน-เวลานัดรับสำเร็จ"
        ], 200);
    }

    public function prepareGoods(AOrder $order)
    {
        // if ($order->sum_all["sumBalance"] != 0) {
        //     return response()->json([
        //         "status" => "failed",
        //         "title" => "ไม่สำเร็จ",
        //         "icon" => "error",
        //         "message" => "มียอดคงเหลืิอค้างอยู่"
        //     ], 201);
        // }

        if ($order->status != 3 && $order->status != 4) {
            return response()->json([
                "status" => "failed",
                "title" => "ไม่สำเร็จ",
                "icon" => "error",
                "message" => "สถานะสินค้าไม่ถูกต้อง"
            ], 201);
        }

        $order->update(["status" => "8"]);

        AlertMessages::linePrepareGoods($order);
        AlertMessages::smsPrepareGoods($order);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success",
            "message" => "เตรียมสินค้าเรียบร้อย"
        ], 200);
    }

    public function pickUpGoods(AOrder $order, Request $request)
    {
        // dd($order->sum_all["sumBalance"]);
        if ($order->status != 8) {
            return response()->json([
                "status" => "failed",
                "title" => "ไม่สำเร็จ",
                "icon" => "error",
                "message" => "สถานะสินค้าไม่ถูกต้อง"
            ], 201);
        }

        if (
            isset($order->orderDeliveryService) &&
            $order->orderDeliveryService->status != "success"
        ) {
            return response()->json([
                "status" => "failed",
                "title" => "ไม่สำเร็จ",
                "icon" => "error",
                "message" => "โปรดจัดส่งสินค้าให้เสร็จสิ้นก่อน"
            ], 201);
        }

        if ($order->sum_all["sumBalance"] != 0) {
            return response()->json([
                "status" => "failed",
                "title" => "ไม่สำเร็จ",
                "icon" => "error",
                "message" => "ยอดคงเหลือ ต้องเท่ากับ 0"
            ], 201);
        }


        $order->update(["status" => 9]);

        AlertMessages::linePickUpGoods($order);


        if ($request->is_AddScore) {
            CustomerScore::addScore($order->customer, $order->sumForScore());
        }

        AlertMessages::smsPickUpGoods($order);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success",
            "message" => "ลูกค้าได้รับสินค้าเรียบร้อย"
        ], 201);
    }

    public function customerNoPayment(AOrder $order, Request $request)
    {
        if ($order->status != 1) {
            return response()->json([
                "status" => "error",
                "title" => "ไม่สำเร็จ",
                "icon" => "error",
                "message" => "สถานะไม่ถูกต้อง"
            ], 201);
        }

        $order->update([
            "status" =>
            $request->option["status_id"]
        ]);

        AlertMessages::smsCustomerNoPayment($order, $request->option["waiting_period"]);
        AlertMessages::lineCustomerNoPayment($order);

        return response()->json([
            "status" => "success",
            "title" => "สำเร็จ",
            "icon" => "success",
            "text" => "ดำเนินการเรียบร้อย"
        ], 200);
    }

    public function fetch_orders(Request $request)
    {

        $query = AOrder::query();

        if ($request->get("search") != null) {
            // dd("dsad");
            $query->where("id", $request->get("search"));
            $query->orWhereHas("customer", function ($q) use ($request) {
                $q->where("tel", $request->get("search"));
                $q->orWhere("name", $request->get("search"));
            });
            $query->orWhereHas("orderDetails", function ($q) use ($request) {
                $q->Where("message", "like", "%" . $request->get("search") . "%");
                $q->orWhere("detail", "%" . $request->get("search") . "%");
            });
        }

        // if ($request->get("order_id") != null) {
        //     $query->where("id", $request->get("order_id"));
        // }

        // if ($request->get("customer_phone") != null) {
        //     $query->whereHas("customer", function ($q) use ($request) {
        //         return $q->where("tel", $request->get("customer_phone"));
        //     });
        // }

        if ($request->get("status") != null) {
            $query->whereIn("status", explode(",", $request->get("status")));
        }

        if ($request->get("date_get") != null) {
            $query->where("date_get", $request->get("date_get"));
        }

        if ($request->get("sort_date_get") != null) {
            $query->orderBy("date_get", $request->get("sort_date_get"));
        }

        if ($request->get("sort_time_get") != null) {
            $query->orderBy("time_get", $request->get("sort_time_get"));
        }

        if ($request->get("sort_id") != null) {
            $query->orderBy("id", $request->get("sort_id"));
        }

        if ($request->get("with") != null) {
            $explodes = explode(",", $request->get("with"));
            foreach ($explodes as $e) {
                $query->with($e);
            }
        }

        $result = $query->get();

        if ($request->get("makeHidden") != null) {
            $makeHidden = explode(",", $request->get("makeHidden"));
            $result->makeHidden($makeHidden);
        }

        return $result;
    }

    public function pos_fetch(Request $request)
    {
        // dd($request->get("date_get"));
        // dd($request);
        //$query = OrderDetail::query();

        $query = AOrder::
            // with([
            //     "aOrder" => function ($q) {
            //         $q->select("id", "date_get", "time_get");
            //         // $q->orderBy("time_get", "asc");
            //     }
            // ])->
            // with(
            //     "aOrder:id,date_get,time_get",
            //     "aOrder.orderDeliveryService",
            //     "aPrice.googleImage",
            //     "addOns.productAddOn.goodsAddOn",
            //     "imageFromCustomers.googleImage",
            //     "productPrototypes.googleImage"
            // )
            // $detail = OrderDetail::whereHas("aOrder", function ($query) use ($request) {
            //     return $query->where("auth_order", $request->uuid);
            // })->findOrFail($request->order_detail_id);
            whereHas("posOrders")->with("posOrders.posGoods")
            ->with("aStatus:id,class,status")

            // ->whereHas("aOrder", function ($q) use ($request) {
            //     $q->where("date_get", $request->get("date_get"));
            //     //$q->where("status", "<", "8");
            // })
            ->where("date_get", $request->get("date_get"))
            ->where("status", "<", "8")
            ->orderBy("time_get", "ASC")
            ->get();



        // foreach ($query as $q) {
        //     $q->setAppends(["time_get_format"]);
        // }

        return $query->makeHidden(["sum_all"]);

        return $query;
    }

    public function fetch_pre_pos_lists(Request $request)
    {
        // dd($request);
        //$query = OrderDetail::query();

        $query = AOrder::
            // with([
            //     "aOrder" => function ($q) {
            //         $q->select("id", "date_get", "time_get");
            //         // $q->orderBy("time_get", "asc");
            //     }
            // ])->
            // with(
            //     "aOrder:id,date_get,time_get",
            //     "aOrder.orderDeliveryService",
            //     "aPrice.googleImage",
            //     "addOns.productAddOn.goodsAddOn",
            //     "imageFromCustomers.googleImage",
            //     "productPrototypes.googleImage"
            // )
            // $detail = OrderDetail::whereHas("aOrder", function ($query) use ($request) {
            //     return $query->where("auth_order", $request->uuid);
            // })->findOrFail($request->order_detail_id);
            whereHas("posOrders")->with("posOrders.posGoods")
            ->with("aStatus:id,class,status")

            // ->whereHas("aOrder", function ($q) use ($request) {
            //     $q->where("date_get", $request->get("date_get"));
            //     //$q->where("status", "<", "8");
            // })
            ->where("date_get", ">=", now()->addDays(1)->format("Y-m-d"))
            ->where("status", "<", "8")
            ->orderBy("date_get", "ASC")
            ->orderBy("time_get", "ASC")
            ->get();



        foreach ($query as $q) {
            $q->setAppends(["date_get_th", "time_get_format"]);
        }

        return $query->makeHidden(["sum_all"]);

        return $query;
    }

    public function check_uuid($uuid)
    {
        $order = AOrder::whereAuthOrder($uuid)
            ->where("date_get", ">=", now()->format("Y-m-d"))
            ->where("payment_deadline", ">=", now()->format("Y-m-d H:i:s"))
            ->with("customer:id,name,tel")
            ->first();

        if ($order) {
            return response()->json([
                "order" => $order,
                "status" => true
            ], 200);
        }

        return response()->json([
            "status" => false
        ], 200);
    }

    public function summaryOfOrderDetails(AOrder $order)
    {
        AOrder::summaryOfOrderDetails($order->id);

        return response()->json([
            "title" => "ส่งสรุปรายการเรียบร้อย",
            "icon" => "success"
        ], 200);
    }

    public function update_channel_order(AOrder $order, $channel_id)
    {
        $order->update([
            "channel" => $channel_id
        ]);
        return response()->json([
            "title" => "เปลี่ยนแปลงช่องทางการสั่งซื้อสำเร็จ",
            "message" => "เปลี่ยนแปลงช่องทางการสั่งซื้อสำเร็จ",
            "icon" => "success",
            "status" => "success"
        ], 200);
    }

    public function use_point_by_order_id(AOrder $order, Request $request)
    {
        if ($order->usePoint() != 0) {
            return response()->json([
                "icon" => "error",
                "title" => "เกิดข้อผิดพลาดบางอย่าง",
                "text" => "รายการสั่งซื้อนี้ ใช้คะแนนสะสมแล้ว"
            ], 200);
        }

        if ($request->point > $order->sumGoods() / 2) {
            return response()->json([
                "icon" => "error",
                "title" => "เกิดข้อผิดพลาดบางอย่าง",
                "text" => "คะแนนที่ใช้ มากกว่า 50% ของรายการสั่งซื้อที่จะสามารถใช้ได้"
            ], 200);
        }

        if ($request->point > $order->customer->sumDiffScore()) {
            return response()->json([
                "icon" => "error",
                "title" => "เกิดข้อผิดพลาดบางอย่าง",
                "text" => "คะแนนที่ใช้ มากกว่า คะแนนที่มีอยู่"
            ], 200);
        }

        CustomerScore::useScore(
            $order->customer->id,
            $request->point,
            0,
            null,
            $order->id
        );

        return response()->json([
            "icon" => "success",
            "title" => "ดำเนินการเรียบร้อย",
            "text" => "ใช้คะแนนเรียบร้อยค่ะ"
        ], 200);
    }

    public function remove_use_point_by_order_id(AOrder $order)
    {

        $order->CustomerScore->delete();
        return response()->json([
            "icon" => "success",
            "title" => "ดำเนินการเรียบร้อย",
            "text" => "ยกเลิกการใช้คะแนนสะสมเรียบร้อย"
        ], 200);
    }

    public function update_alert_facebook_by_prepare(AOrder $order, Request $request)
    {
        // dd($request->alert_facebook_by_prepare);
        $order->alert_facebook_by_prepare = $request->alert_facebook_by_prepare;
        $order->save();

        return response()->json([
            "icon" => "success",
            "title" => "ดำเนินการเรียบร้อย",
            "text" => "เปลี่ยนแปลงการแจ้งเตือนไปยัง Facebook เมื่อจัดเตรียมสินค้าเสร็จ"
        ], 200);
    }
}
