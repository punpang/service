<?php

namespace App\Console\Commands;

use App\MSms;
use App\Linenotify;
use App\Order\AOrder;
use Illuminate\Console\Command;

class PaymentNotificationOfTomorrowOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Notify:PaymentOfTomorrowOrder';

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
        $orders = AOrder::where("payment_deadline", now()->format("Y-m-d 13:00:00"))
            ->where("status", "1")
            ->whereDate("created_at", "<", now()->format("Y-m-d"))
            // ->where("payment_deadline", now()->format("Y-m-d") . " 12:00:00")
            ->get();
        foreach ($orders as $order) {
            $message = "หมายเลขคำสั่งซื้อ #$order->id ของคุณ ยังไม่ได้ยืนยันการสั่งซื้อ โปรดชำระเงินภายใน $order->payment_deadline_th น. เพื่อรับคิว $order->date_time_get_th น. สามารถชำระเงินได้ที่ [ $order->link_for_customer ]";
            MSms::Sms($order->customer->tel, $message);
        }

        Linenotify::send("แจ้งเตือนลูกค้าให้ชำระเงินสำหรับรายการสั่งซื้อในวันที่ " . now()->addDays(1)->format("d/m/Y") . " จำนวน " . $orders->count() . " รายการ เรียบร้อยแล้ว");
    }
}
