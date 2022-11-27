<?php

namespace App\Console\Commands;

use App\MSms;
use App\Linenotify;
use App\Order\AOrder;
use Illuminate\Console\Command;

class alertToCustomerGetBeforeClose extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AlertCustomer:GetBeforeClose';

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
        $datas = AOrder::where("date_get", now()->format("Y-m-d"))
            ->whereIn("status", [3, 4, 5, 6, 7, 8])
            ->with("customer:id,tel")
            ->get();

        foreach ($datas as $data) {
            $message = "หมายเลขคำสั่งซื้อ #$data->id ของท่าน สามารถรับสินค้าได้ตั้งเวลานัดรับ $data->time_get_format น. เป็นต้นไป แต่ไม่เกินเวลาร้านปิด

*ร้านปิด 19:00 น. โปรดรับสินค้าของท่านก่อนเวลาร้านปิด*";

            MSms::sms($data->customer->tel, $message);
        }

        Linenotify::send("แจ้งลูกค้ารับสินค้าก่อนร้านปิดแล้ว");
    }
}
