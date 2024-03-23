<?php

namespace App\Order;

// use Bitly;
// use App\URL;
// use App\Linenotify;
use App\Pos\Order;
// use App\Linenotify;
use App\Order\Line;
use App\Order\OrderDetail;
use Illuminate\Support\Str;
use App\Order\AHistoryPayed;
use App\Order\AlertMessages;
use App\Order\DeliveryService;
use Illuminate\Database\Eloquent\Model;
use App\Order\AdjustExcessPaymentChannel;
use App\Order\NoticeOfPaymentFromCustomer;

class AOrder extends Model
{
    protected $table = "a_order";

    protected $connection = 'order';
    // public $timestamps = false;

    protected $primaryKey = "id";

    // protected $fillable = [
    //     "id_customer",
    //     "date_get",
    //     "time_get",
    //     "channel",
    //     "status",
    //     "date_order",
    //     "auth_order",
    //     "payment_deadline"
    // ];

    protected $guarded = [];

    protected $appends = [
        "sum_all",
        "payment_deadline_th",
        "status_payment_deadline",
        "date_get_default",
        "created_at_th",
        "date_get_th",
        "time_get_format",
        //"link_for_customer"
        // "sum_add_on"
    ];

    // public function getDateGetAttribute($date)
    // {
    //     // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
    //     return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->addYears(543)->format('d-m-Y');
    // }

    public function getDateGetThAttribute()
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->date_get)->addYears(543)->format('d-m-Y');
    }


    public function getDateGetDefaultAttribute()
    {
        return \Carbon\Carbon::parse($this->date_get)->subYears(543)->format('Y-m-d');
    }

    // public function getTimeGetAttribute($date)
    // {
    //     // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
    //     return \Carbon\Carbon::createFromFormat('H:i:s', $date)->format('H:i');
    // }


    public function getTimeGetFormatAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->time_get)->format('H:i');
    }

    public function getDateTimeGetThAttribute()
    {
        return $this->date_get_th . " " . $this->time_get_format;
    }

    public function getCreatedAtThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->addYears(543)->format('d-m-Y H:i');
    }

    public function getLinkForCustomerAttribute()
    {
        // return Bitly::getUrl(URL::base() . "/o/" . $this->auth_order);
        $shotlink = ShotlinkV2::store("/o/" . $this->auth_order);
        return $shotlink;
    }


    public function getPaymentDeadlineThAttribute()
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        if ($this->payment_deadline == null) {
            return $this->payment_deadline;
        }
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->payment_deadline)->addYears(543)->format('d/m/Y H:i:s');
    }

    public function getStatusPaymentDeadlineAttribute()
    {
        $now = \Carbon\Carbon::now();
        $payment_deadline = \Carbon\Carbon::parse($this->payment_deadline);
        return $payment_deadline->timestamp > $now->timestamp;
    }

    public function dateGetTimeFormat()
    {
        return $this->date_get . " " . $this->time_get;
    }

    // public function dateGetTime()
    // {
    //     return \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $this->date_get . " " . $this->time_get . ":00")->subYears(543)->format('Y-m-d H:i:s');
    // }

    public function customer()
    {
        return $this->belongsTo(ACustomer::class, "id_customer", "id");
    }

    public function CustomerScore()
    {
        return $this->hasOne(CustomerScore::class, "order_id", "id");
    }

    public function usePoint()
    {
        if ($this->CustomerScore == null) {
            return 0;
        }

        return $this->CustomerScore->point;
    }

    public function imageFromCustomers()
    {
        return $this->hasMany(ImageFromCustomer::class, "order_id", "id")->whereStatusUse(1)->orderBy('created_at', "desc");
    }

    // public function am1()
    // {
    //     return $this->belongsTo(AM1::class, "m1", "id");
    // }

    // public function am2()
    // {
    //     return $this->belongsTo(AM2::class, "m2", "id");
    // }

    // public function am3()
    // {
    //     return $this->belongsTo(AM3::class, "m3", "id");
    // }

    // public function am4()
    // {
    //     return $this->belongsTo(AM4::class, "m4", "id");
    // }

    // public function setNameGoods()
    // {
    //     return $this->am1->m1 . ":" . $this->am2->m2 . ":" . $this->am3->m3 . ":" . $this->am4->m4;
    // }

    // public function getNameGoodsAttribute()
    // {
    //     return $this->am1->m1 . ":" . $this->am2->m2 . ":" . $this->am3->m3 . ":" . $this->am4->m4;
    // }

    public function aStatus()
    {
        return $this->belongsTo(AStatus::class, "status", "id");
    }


    public function aHistoryPayed()
    {
        return $this->hasMany(AHistoryPayed::class, "id_order", "id")->orderBy("id", "desc");
    }

    public function historyPaid()
    {
        return $this->hasMany(AHistoryPayed::class, "id_order", "id"); //;
    }

    public function ntpfcs()
    {
        // notice_of_payment_from_customers
        return $this->hasMany(NoticeOfPaymentFromCustomer::class, "order_id", "id");
    }

    public  function ntpfcsForCustomer()
    {
        // notice_of_payment_from_customers
        return $this->ntpfcs()->select("id", 'order_id', 'src_name', 'status', 'amount', "created_at")
            ->orderBy('created_at', 'DESC');
    }

    public function sumHistoryPayed()
    {
        return $this->aHistoryPayed->where("status_use", "1")->sum("value");
    }

    public function sumGoods()
    {
        return $this->orderDetails()->sum("price") + $this->sumAddOn() + $this->sumPosOrder();
    }

    // public function getSumAddOnAttribute()
    // {
    //     return $this->orderDetails->addOns();
    // }

    public function sumAddOn()
    {

        return $this->orderDetails->sum("sum_add_on");
    }

    public function sumDeposited()
    {
        return $this->sumHistoryPayed();
    }

    public function sumAll()
    {
        return [
            "sumGoods" => $this->sumGoods(),
            "sumASC" => $this->sumAccessoryServiceDiscount(),
            "sumTASC" => $this->sumTASC(),
            "sumGoodsVat7" => $this->sumGoodsVat7(),
            "vat7" => $this->vat7(),
            "sumBalance" => $this->sumBalance(),
            "sumDeposited" => $this->sumDeposited(),
            "sumAccessory" => $this->sumAccessory(),
            "sumService" => $this->sumService(),
            "sumDiscount" => $this->sumDiscount(),
            "sumAddOn" => $this->sumAddOn(),
            "sumDeliverService" => $this->sumDeliverService(),
            "sumAdjustExcessPayment" => $this->sumAdjustExcessPayment(),
            "sumMoneyService" => $this->sumMoneyService(),
            "sumMoneyCustomer" => $this->sumMoneyCustomer(),
            "sumPosOrder" => $this->sumPosOrder(),
            "usePoint" => $this->usePoint(),
            "useCoupon" => $this->useCoupon(),
            // "sumHistoryPayed" => $this->sumHistoryPayed()
        ];
    }

    // public function sumAll()
    // {
    //     return [
    //         "sumGoods" => number_format($this->sumGoods(), 2),
    //         "sumASC" => number_format($this->sumAccessoryServiceDiscount(), 2),
    //         "sumTASC" => number_format($this->sumTASC(), 2),
    //         "sumBalance" => number_format($this->sumBalance(), 2),
    //         "sumDeposited" => number_format($this->sumDeposited(), 2),
    //         "sumAccessory" => number_format($this->sumAccessory(), 2),
    //         "sumService" => number_format($this->sumService(), 2),
    //         "sumDiscount" => number_format($this->sumDiscount(), 2),
    //         "sumAddOn" => number_format($this->sumAddOn(), 2),
    //         "sumDeliverService" => number_format($this->sumDeliverService(), 2),
    //         "sumAdjustExcessPayment" => number_format($this->sumAdjustExcessPayment(), 2),
    //         "sumMoneyService" => number_format($this->sumMoneyService(), 2),
    //         "sumMoneyCustomer" => number_format($this->sumMoneyCustomer(), 2)
    //         // "sumHistoryPayed" => $this->sumHistoryPayed()
    //     ];
    // }

    public function getSumAllAttribute()
    {
        return $this->sumAll();
    }

    public function vat7()
    {
        // return $this->sumGoods() * 7 / 100;
        return ($this->sumGoods() * 7 / 100) + ($this->usePoint() * 7 / 100);
    }

    public function sumGoodsVat7()
    {
        // return $this->sumGoods()+ $this->vat7();
        return $this->sumGoods() + $this->usePoint() + $this->vat7();
    }

    public function sumAdjustExcessPayment()
    {
        return $this->adjustExcessPayments()->sum("amount");
    }

    public function sumMoneyCustomer()
    {
        return $this->orderDetails->sum("sumMoneyCustomer");
    }

    public function sumMoneyService()
    {
        return $this->orderDetails->sum("sum_money_service");
    }

    // public function sumBalance()
    // {
    //     return $this->sumTASC()
    //         - $this->sumDeposited()
    //         + $this->sumAdjustExcessPayment();
    // }

    public function sumBalance()
    {
        return $this->sumTASC()
            - $this->sumDeposited()
            + $this->sumAdjustExcessPayment();
    }

    public function sumForScore()
    {
        return  $this->sumGoods() +
            $this->sumAccessoryServiceDiscount();
    }

    // public function sumTASC()
    // {
    //     return  $this->sumGoods() +
    //         $this->sumAccessoryServiceDiscount() +
    //         $this->sumDeliverService() +
    //         $this->sumMoneyCustomer() +
    //         $this->sumMoneyService() +
    //         $this->usePoint() -
    //         $this->useCoupon();
    // }

    public function sumTASC()
    {
        return  $this->sumGoodsVat7() +
            $this->sumAccessoryServiceDiscount() +
            $this->sumDeliverService() +
            $this->sumMoneyCustomer() +
            $this->sumMoneyService() +
            // $this->usePoint() -
            $this->useCoupon();
    }

    public function getSumTascAttribute()
    {
        return  $this->sumGoods() + $this->sumAccessoryServiceDiscount();
    }

    public function aAccessory()
    {
        return $this->belongsTo(AAccessory::class, "id", "id_order");
    }

    public function sumAccessory()
    {
        if (!empty($this->aAccessory->total)) {
            $a = $this->aAccessory->total;
        } else {
            $a = 0;
        }
        return $a;
    }

    public function aService()
    {
        return $this->belongsTo(AService::class, "id", "id_order");
    }

    public function sumService()
    {
        if (!empty($this->aService->total)) {
            $s = $this->aService->total;
        } else {
            $s = 0;
        }
        return $s;
    }

    public function aDiscount()
    {
        return $this->belongsTo(ADiscount::class, "id", "id_order");
    }

    public function sumDiscount()
    {
        if (!empty($this->aDiscount->discount)) {
            $d = $this->aDiscount->discount;
        } else {
            $d = 0;
        }
        return $d;
    }

    public function sumAccessoryServiceDiscount()
    {
        return ($this->sumAccessory() + $this->sumService()) -
            $this->sumDiscount();
    }

    public function testPaymentByOrderID($request)
    {


        // dd($data);
        // dd(request()->all());
        // $order = self::findOrFail($order_id);

        if ($this->sumTASC() !== $this->sumDeposited() + $this->sumBalance()) {
            return response()->json([
                "message" => "จำนวนเงินไม่ถูกต้อง",
                "status" => "error"
            ], 201);
        }

        if ($this->auth_order == null) {
            $this->auth_order = Str::uuid();
        }

        // $this->deposit = $this->sumDeposited() + $amount;
        // $this->balance = $this->sumBalance() - $amount;

        if ($this->status <= 2) {
            $this->status = 3;
        }

        $this->save();

        $this->historyPaid()->create([
            'value' => $request->amount,
            'channel_payment_id' => $request->channel["id"],
            "user" => "new_system",
            "list" => 9,
            "billno" => 1,
            "date_time" => \Carbon\Carbon::now()
        ])
            ->customerScore()->create([
                "customer_id" => $this->customer->id,
                "point" => $request->amount,
                "expiration_date" => \Carbon\Carbon::now()
            ])->testAddScore();

        // $customerScore = new CustomerScore;
        // $customerScore->useScore($this->customer->id, 10, 0);

        return $this;
        // if ($order) {
        //     return ["order" => $order, "status" => "success"];
        // } else {
        //     return ["status" => "fail"];
        // }
    }

    public static function paymentByOrderID($order_id, $amount = 0)
    {
        // dd($data);
        // dd(request()->all());
        $order = self::findOrFail($order_id);

        if ($order->sumTASC() != $order->sumDeposited() + $order->sumBalance() - $order->sumAdjustExcessPayment()) {
            return response()->json([
                "message" => "จำนวนเงินไม่ถูกต้อง",
                "status" => "error"
            ], 201);
        }

        if ($order->auth_order == null) {
            $order->auth_order = Str::uuid();
        }

        // $order->deposit = $order->sumDeposited() + $amount;
        // $order->balance = $order->sumBalance() - $amount;

        if ($order->status <= 4) {
            $order->status = 3;
        }

        $order->save();

        if ($order) {
            return ["order" => $order, "status" => "success"];
        } else {
            return ["status" => "fail"];
        }
    }

    // public static function genlinkUuid($order_id)
    // {
    //     $order = AOrder::findOrFail($order_id);
    //     $link = URL::base() . "/o/" . $order->auth_order;
    //     $bitly = Bitly::getUrl($link);
    //     return $bitly;
    // }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, "order_id", "id");
    }

    public function orderDetailsNull()
    {
        return $this->hasMany(OrderDetail::class, "order_id", "id")->whereNull("order_detail_id");
    }

    public function orderDetailsOnlyTrashed()
    {
        return $this->orderDetails()->onlyTrashed();
    }

    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class, "order_id", "id")->orderBy("created_at", "desc");
    }

    public function couponUsed()
    {
        return $this->hasOne(CouponUsed::class, "order_id", "id");
    }

    public function useCoupon()
    {
        if ($this->couponUsed == null) {
            return 0;
        }

        return $this->couponUsed->discount;
    }

    public function orderDeliveryService()
    {
        return $this->hasOne(DeliveryService::class, "order_id", "id");
    }

    public function sumDeliverService()
    {
        return $this->orderDeliveryService()->sum("delivery_fee");
    }

    public function alertMessages()
    {
        return AlertMessages::class;
    }

    public function adjustExcessPayments()
    {
        return $this->hasMany(AdjustExcessPayment::class, "order_id", "id");
    }

    public function OrderChannel()
    {
        return $this->belongsTo(OrderChannel::class, "channel", "id");
    }

    public function posOrders()
    {
        return $this->hasMany(Order::class, "order_id", "id");
    }

    public function sumPosOrder()
    {
        return $this->posOrders()->sum("total");
    }

    public static function summaryOfOrderDetails($order_id, $show_conditions = false)
    {
        $order = AOrder::findOrFail($order_id);

        if ($order->sumMoneyCustomer() > 0 || $order->orderDeliveryService) {
            $order->update(["status_full_payment" => 1]);
        }

        $m = "";
        foreach ($order->orderDetails as $key_detail => $detail) {
            $a = "";
            foreach ($detail->addOns as $key => $addOn) {
                $a = $a . $addOn->productAddOn->goodsAddOn->name . ($key + 1 != $detail->addOns->count() ? " ," : "");
            }
            if ($a) {
                $aa = "
เพิ่มเติม : $a";
            } else {
                $aa = "";
            }

            if ($detail->moneyServices->count() > 0) {
                $ms = "";
                foreach ($detail->moneyServices as $key_moneyService => $moneyService) {
                    $ms = $ms . "
" . ($key_moneyService + 1) . ".บริการ : " . $moneyService->category_money_service->text . "
฿20x" . $moneyService->thb20 . " ฿50x" . $moneyService->thb50 . " ฿100x" . $moneyService->thb100 . "
฿500x" . $moneyService->thb500 . " ฿1,000x" . $moneyService->thb1000 . "
จำนวนเงิน : " . $moneyService->sum_money_format . " บาท
ค่าบริการ : " . number_format($moneyService->category_money_service->fee, 2) . " บาท";
                }

                $message_money_services = "

บริการเกี่ยวกับเงิน $ms";
            } else {
                $message_money_services = "";
            }

            $layer_multi_cake =  $detail->order_detail_id != null ?
                "
                ชั้นที่ " . $detail->sort_group_multi_cake . "[#" . $detail->color_multi_cake["number"] . "]"  : "";

            /////
            $message = $detail->message != "-" ? "
ข้อความ : " . $detail->message : "";
            $remark = $detail->detail != "-" ? "
หมายเหตุ : " . $detail->detail : "";

            ////
            $m = $m . "รายการที่ " . ($key_detail + 1) . "
" . $detail->aPrice->name_goods . $layer_multi_cake  . $aa .  $message . $remark . "
ราคา " . $detail->sum_total . " บาท $message_money_services
(vat 7% : ฿" . number_format($detail->sum_total_not_format * 7 / 100, 2) . ")
-------------------------
";
        }


        $message_pos = "";
        if ($order->posOrders->count() > 0) {
            foreach ($order->posOrders as $pos) {
                $msg_pos_note = is_null($pos->note) ? "" : "
#$pos->note#";
                $message_pos = $message_pos . "
" . $pos->posGoods->text . "
฿" . number_format($pos->price, 2) . " x " . $pos->quantity . " = ฿" . number_format($pos->total, 2) . $msg_pos_note;
            }
            $message_pos = $message_pos . "

รวม " . number_format($order->sumPosOrder(), 2) . " บาท
(vat 7% : ฿" . number_format($order->sumPosOrder() * 7 / 100, 2) . ")

-------------------------";
        }

        if ($order->orderDeliveryService) {
            $message_delivery_service = "บริการจัดส่ง
ชื่อผู้รับ : " . $order->orderDeliveryService->recipient_name . "
เบอร์โทรผู้รับ : " . $order->orderDeliveryService->recipient_phone . "
วัน-เวลาจัดส่งถึงโดยประมาณ :
" . $order->date_get_th . " " . $order->time_get_format . " - " . \Carbon\Carbon::createFromFormat("H:i", $order->time_get_format)->addMinutes(30)->format("H:i") . " น.
สถานที่จัดส่ง : " . $order->orderDeliveryService->link_google_maps . "
ค่าบริการ : " .  number_format($order->orderDeliveryService->delivery_fee, 2) . " บาท
-------------------------
";
        } else {
            $message_delivery_service = "";
        }

        if ($order->payment_deadline >= now()->format('Y-m-d H:i:s')) {
            // $order->status < 3 && $order->payment_deadline_th != null
            $message_payment_deadline_th = "โปรดชำระเงินภายใน
" . $order->payment_deadline_th . " น.
-------------------------";
        } else {
            $message_payment_deadline_th = "";
        }

        if ($show_conditions) {
            $msg_conditutions = "
โปรดศึกษาเงื่อนไขการสั่งซื้อได้ที่
https://punpang.net/learning/conditions/order";
        } else {
            $msg_conditutions = "";
        }

        $usePoints = $order->usePoint() != 0 ? "
ใช้คะแนนสะสม " . $order->usePoint() . " คะแนน" :
            "";


        $msg = "หมายเลขคำสั่งซื้อ #$order->id
ชื่อลูกค้า : " . $order->customer->name . "
เบอร์โทร : " . $order->customer->tel . "
-------------------------
วัน-เวลารับสินค้า
" . $order->date_time_get_th . " น.
-------------------------
" . $m . $message_pos . "
" . $message_delivery_service . "ยอดทั้งหมด " . number_format($order->sumTASC(), 2) . " บาท
รวม vat 7% " . number_format($order->vat7(), 2) . " บาท
ยอดชำระแล้ว " . number_format($order->sumDeposited(), 2) . " บาท " . $usePoints . "
-------------------------
ยอดคงเหลือ " . number_format($order->sumBalance(), 2) . " บาท
-------------------------
สถานะ : " . $order->aStatus->status . "
-------------------------
$message_payment_deadline_th
หลังจากลูกค้าชำระเงินแล้ว
ทางร้านสงวนสิทธิ์ลูกค้าตรวจสอบรายการสั่งซื้อแล้ว$msg_conditutions";

        // Linenotify::send($msg);

        Facebook::send_reply_message($order, $msg);
        // Line::reply_message_v2($order, $msg);
        return $msg;
    }

    // กสิกร
    // 004100060000010103 0040220012337102836COR028185102TH9104DF82 k
    // 004100060000010103 0040220012337102916BPM037585102TH9104976B k

    // ไทยพาณิชย์
    // 004600060000010103 0140225202211291eJPPZehIQluerhOm5102TH9104C2C3 scb

    // กรุงไทย
    // 003700060000010103 006021620221127740002415102TH910460A6
    // 003700060000010103 006021620221201648403365102TH91049F68

    // ออมสิน
    // 004500060000010103 0300224233310508432I000020B97905102TH91043DB8

    // กรุงเทพ
    // 004600060000010103 002022520221201121542240057248085102TH91040070

}
