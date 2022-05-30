<?php

namespace App\Order;

use Bitly;
use App\URL;
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
        "created_at_th"
        //"link_for_customer"
        // "sum_add_on"
    ];

    public function getDateGetAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->addYears(543)->format('d-m-Y');
    }


    public function getDateGetDefaultAttribute()
    {
        return \Carbon\Carbon::parse($this->date_get)->subYears(543)->format('Y-m-d');
    }

    public function getTimeGetAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('H:i:s', $date)->format('H:i');
    }

    public function getCreatedAtThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->addYears(543)->format('d-m-Y H:i');
    }

    public function getLinkForCustomerAttribute()
    {
        return Bitly::getUrl(URL::base() . "/o/" . $this->auth_order);
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
        return $this->orderDetails()->sum("price");
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
            "sumGoods" => number_format($this->sumGoods(), 2),
            "sumASC" => number_format($this->sumAccessoryServiceDiscount(), 2),
            "sumTASC" => number_format($this->sumTASC(), 2),
            "sumBalance" => number_format($this->sumBalance(), 2),
            "sumDeposited" => number_format($this->sumDeposited(), 2),
            "sumAccessory" => number_format($this->sumAccessory(), 2),
            "sumService" => number_format($this->sumService(), 2),
            "sumDiscount" => number_format($this->sumDiscount(), 2),
            "sumAddOn" => number_format($this->sumAddOn(), 2),
            "sumDeliverService" => number_format($this->sumDeliverService(), 2),
            "sumAdjustExcessPayment" => number_format($this->sumAdjustExcessPayment(), 2)
            // "sumHistoryPayed" => $this->sumHistoryPayed()
        ];
    }

    public function getSumAllAttribute()
    {
        return $this->sumAll();
    }

    public function sumAdjustExcessPayment()
    {
        return $this->adjustExcessPayments()->sum("amount");
    }

    public function sumBalance()
    {
        return $this->sumTASC()
            - $this->sumDeposited()
            + $this->sumAdjustExcessPayment();
    }

    public function sumTASC()
    {
        return  $this->sumGoods() + $this->sumAccessoryServiceDiscount() + $this->sumDeliverService();
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
        return ($this->sumAddOn() + $this->sumAccessory() + $this->sumService()) -
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

        if ($order->sumTASC() !== $order->sumDeposited() + $order->sumBalance() - $order->sumAdjustExcessPayment()) {
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

        if ($order->status <= 2) {
            $order->status = 3;
        }

        $order->save();

        if ($order) {
            return ["order" => $order, "status" => "success"];
        } else {
            return ["status" => "fail"];
        }
    }

    public static function genlinkUuid($order_id)
    {
        $order = AOrder::findOrFail($order_id);
        $link = URL::base() . "/o/" . $order->auth_order;
        $bitly = Bitly::getUrl($link);
        return $bitly;
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, "order_id", "id");
    }

    public function orderDetailsOnlyTrashed()
    {
        return $this->orderDetails()->onlyTrashed();
    }

    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class, "order_id", "id")->orderBy("created_at", "desc");
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
}
