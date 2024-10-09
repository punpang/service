<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order\AOrder;
use App\Order\AlertMessages;

class SumOrderTodayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Alert:SumOrderToday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // AlertMessages::LineAlertGeneral("SumOrderTodayCommand");

        $orders = AOrder::whereDateGet(now()->format('Y-m-d'))
            ->whereStatus(9)
            ->get();


        $count_order_details = 0;
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                if ($detail->order_detail_id == null || $detail->order_detail_id == $detail->id) {
                    $count_order_details += 1;
                }
            }
        }
        // AlertMessages::LineAlertGeneral("count_order_details => " . $count_order_details);

        $count_pos = 0;
        foreach ($orders as $order) {
            if ($order->sumPosOrder() >= 200) {
                $count_pos += 1;
            }
        }
        // AlertMessages::LineAlertGeneral("count_pos => " . $count_pos);

        $sum_total = 0;
        foreach ($orders as $order) {
            $sum_total += $order->sumForScore();
        }
        // AlertMessages::LineAlertGeneral("sum_total => " . $sum_total);

        $sum_delivery = 0;
        foreach ($orders as $order) {
            $sum_delivery += $order->orderDeliveryService()->count();
        }
        // AlertMessages::LineAlertGeneral("sum_delivery => " . $sum_delivery);

        $sum_service_money = 0;
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $orderDetail) {
                $sum_service_money += $orderDetail->MoneyServices()->count();
            }
        }
        // AlertMessages::LineAlertGeneral("sum_service_money => " . $sum_service_money);

        $msg = "สรุปยอดรายการสั่งซื้อวันที่ " . now()->addYears(543)->format("d/m/Y") .
            " มีรายการสั่งซื้อจำนวน " . $count_order_details . " รายการ | POS " . $count_pos . " รายการ | รวมเป็นเงิน " . number_format($sum_total, 2)
            . " บาท | บริการจัดส่ง " . $sum_delivery . " รายการ | บริการเกี่ยวกับเงิน " . $sum_service_money . " รายการ";
        AlertMessages::LineAlertGeneral($msg);

    }
}
