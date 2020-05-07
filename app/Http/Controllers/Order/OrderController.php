<?php

namespace App\Http\Controllers\Order;

use App\Order\Order;
use App\Order\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Linenotify;
use App\MSms;
use App\FacebookMessager;

class OrderController extends Controller
{
    public function create()
    {
        $dataRequest = request()->all();
        $dataRequest['token'] = $this->generateToken();
        $order = Order::create($dataRequest);
        //$message = 'รายการสั่งซื้อ #'.$order->id. ' ของคุณ เรากำลังรอยืนยันการสั่งซื้อจากคุณ ยอดชำระทั้งหมด 300.00 บ. โปรดชำระขั้นต่ำ 150 บ. \n\nชำระโอนผ่านธนาคาร 408-672-0266 (พรรษิษฐ์ ศรีสุข) ธนาคารไทยพาณิชย์ แจ้งชำระเงินได้ที่ ...';
        //FacebookMessager::postMessage($order->customer,$order->ChannelOfPurchase->name,$message);
        //MSms::Sms($order->customer->phone,$message);
        //MSms::Sms($order->customer->phone,'รายการสั่งซื้อ #'.$order->id. ' ของคุณ เรากำลังรอยืนยันการสั่งซื้อจากคุณ ยอดชำระทั้งหมด '.number_format($order->total,2).' บ. โปรดชำระขั้นต่ำ '.number_format($order->total/2,2).' บ. \n\nชำระโอนผ่านธนาคาร 408-672-0266 (พรรษิษฐ์ ศรีสุข) ธนาคารไทยพาณิชย์ แจ้งชำระเงินได้ที่ ...');
        Linenotify::send('รายการสั่งซื้อใหม่ #' . $order->id . ' รับเมื่อ ' . $order->dateTime_get);

        return response()->json('success', 200);
    }

    public function TodayOrder()
    {
        return Order::TodayOrder()->get();
    }

    public function CreatedOrder()
    {
        return Order::CreatedOrder()->get();
    }

    public function NotifyOrder()
    {
        return Order::NotifyOrder()->get();
    }

    public function TomorrowOrder()
    {
        return Order::TomorrowOrder()->get();
    }

    public function generateToken($length = 30)
    {
        $timestamp = str_split(\Carbon\Carbon::now()->timestamp);

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $data = '';

        for ($i = 0; $i < $length; $i++) {
            if ($i % 3 == 0 && $i <= 30) {
                $n = ($i / 3) / 1;
                $data .= $timestamp[$n];
            } else {
                $data .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            }
        }

        return $data;
    }


    public function listsMenu()
    {
        return [
            'today' => [
                'text' => "today",
                'count' => $this->TodayOrder()->count(),
                'textBig' => "รายการสั่งซื้อวันนี้",
                'textSmall' => "วันนี้",
                'colorBlock' => "success",
                'colorText' => ""
            ],
            'notify' => [
                'text' => "notify",
                'count' => $this->NotifyOrder()->count(),
                'textBig' => "รอยืนยันการสั่งซื้อ",
                'textSmall' => "รอยืนยัน",
                'colorBlock' => "lime",
                'colorText' => "black--text"
            ],
            'tomorrow' => [
                'text' => "tomorrow",
                'count' => $this->TomorrowOrder()->count(),
                'textBig' => "รายการสั่งซื้อพรุ่งนี้",
                'textSmall' => "พรุ่งนี้",
                'colorBlock' => "light-green",
                'colorText' => "black--text"
            ],
            'created' => [
                'text' => "created",
                'count' => $this->CreatedOrder()->count(),
                'textBig' => "รายการสั่งซื้อใหม่",
                'textSmall' => "รายการใหม่",
                'colorBlock' => "light-blue",
                'colorText' => "black--text"
            ]
        ];
    }

    public function timeGets()
    {
        return [
            "08:30:00",
            "09:00:00",
            "09:30:00",
            "10:00:00",
            "10:30:00",
            "11:00:00",
            "11:30:00",
            "12:00:00",
            "12:30:00",
            "13:00:00",
            "13:30:00",
            "14:00:00",
            "14:30:00",
            "15:00:00",
            "15:30:00",
            "16:00:00",
            "16:30:00",
            "17:00:00",
            "17:30:00",
            "18:00:00",
            "18:30:00",
            "19:00:00",
            "19:30:00",
        ];
    }

    public function all()
    {
        $data = [
            'success' => true,
            'todayOrder' => $this->TodayOrder(),
            'createdOrder' => $this->CreatedOrder(),
            'notifyOrder' => $this->NotifyOrder(),
            'tomorrowOrder' => $this->TomorrowOrder(),
            'menus' => $this->listsMenu(),
        ];

        return response()->json($data, 200);
    }

    public function checkDateTimeForGet()
    {
        $dateTimeGet = request('dateTime_get');
        $now = \Carbon\Carbon::now()->toDateTimeString(); //format("Y-m-d H:i:s")

        if ($dateTimeGet > $now) {
            $orders = Order::where('dateTime_get', $dateTimeGet)->with('Customer', 'ChannelOfPurchase', 'OrderStatus')->get();
            return response()->json([
                'success' => 1,
                'message' => 'เลือกวัน-เวลารับสินค้าสำเร็จ',
                'data' => [
                    'dateTime_get' => $dateTimeGet,
                    'orders' => [
                        'counts' => $orders->count(),
                        'data' => $orders
                    ]
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'ไม่สามารถเลือกเวลาที่ผ่านไปแล้วได้'
            ], 400);
        }
    }

    public function getByToken($token)
    {
        $data = Order::whereToken($token)->with('CustomerNotFB', 'ChannelOfPurchase', 'OrderStatus', 'OrderDetail')->first();
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function getByTokenForPaymentAlert($token)
    {
        try {
            $today = \Carbon\Carbon::now()->addDays(1)->format('Y-m-d 00:00:00');
            $data = Order::whereToken($token)->where('dateTime_get', '<=', $today)
                ->with('CustomerNotFB', 'OrderStatus')
                ->first();
            if ($data) {
                return response()->json([
                    'data' => $data,
                    'sum' => $data->OrderSum()
                ], 200);
            }else{
                return response()->json(['unverifed' => true] , 500);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getByID($order)
    {
        $data = Order::where('id', $order)
            ->with(
                'Customer',
                'ChannelOfPurchase',
                'OrderStatus',
                'OrderDetail.Product.ProductTagUseOnly.ProductCategorySubUseOnly.ProductCategory',
                'OrderDetailNoUse.Product.ProductTagUseOnly.ProductCategorySubUseOnly.ProductCategory',
                "OrderPayment.OrderPaymentMethod",
                "OrderPayment.SlipVerify",
                'SlipNotVerify.SlipVerify',
                'SlipNotVerify.GoogleOcr'
            )
            ->with('OrderDetail.Product.ProductImage')
            ->with('OrderDetailNoUse.Product.ProductImage')
            ->first();

        return response()->json([
            'data' => $data,
            'sum' => $data->OrderSum(),
            'count' => [
                'product' => [
                    'use' => $data->CountOrderDetail(),
                    'nouse' => $data->CountOrderDetailNoUse(),
                ],
                'slipNotVerify' => $data->CountSlipNotVerify(),
                'slipNotVerifyOnly' => $data->CountSlipNotVerifyOnly()
            ]
        ], 200);
    }
}
