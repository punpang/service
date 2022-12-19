<?php

namespace App\Console\Commands;

use App\Helper;
use App\Linenotify;
use App\Order\AlertMessages;
use App\Order\FacebookImages;
use Illuminate\Console\Command;
use App\Order\NoticeOfPaymentFromCustomer;

class FacebookImagesAlertPaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FacebookImages:AlertPaymentCommand';

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
        // Linenotify::send("FacebookImages:AlertPaymentCommand");
        $images = FacebookImages::take(5)->get();
        foreach ($images as $image) {
            $result =  Helper::qrCodeReaderUrl($image->image_url);
            // $dataQr = $result[0]["symbol"][0]["data"];
            if ($result[0]["symbol"][0]["data"] == null) {
                $image->delete();
            } else {
                $dataQr = Helper::substr_slip_ref($result[0]["symbol"][0]["data"]);

                $is_have = NoticeOfPaymentFromCustomer::where("ref", $dataQr)->first();
                if ($is_have) {
                    $image->delete();
                } else {
                    $orders = $image->facebook->customer->orders
                        ->where("status", "<", "9")
                        ->where("payment_deadline", ">=", now()->format("Y-m-d H:i:s"))
                        ->where("date_get", ">=", now()->format("Y-m-d"))
                        ->where("channel", "3")
                        ->sortByDesc("updated_at");

                    if ($orders->count() == 1) {

                        $order = $orders->first();

                        if ($order->sumBalance() > 0) {
                            NoticeOfPaymentFromCustomer::create([
                                "order_id" => $order->id,
                                "src_name" => $image->image_url,
                                "status" => "create",
                                "amount" => $order->sumBalance(),
                                "ref" => $dataQr
                            ]);
                            Linenotify::send("รับชำระเงินจากลูกค้า -> #$order->id -> Facebook");
                        }
                        // AlertMessages::bothNoticeOfPaymentByCustomer($order->id, 0);
                        // AlertMessages::socialNoticeOfPaymentByCustomer($order, 0);
                    } else if ($orders->count() == 0) {
                        Linenotify::send("ลูกค้าส่งสลิปเข้ามาในแชต แต่ไม่มีรายการสั่งซื้อรองรับ");
                    } else {
                        // NoticeOfPaymentFromCustomer::create([
                        //     "order_id" => "00000",
                        //     "src_name" => $image->image_url,
                        //     "status" => "create",
                        //     "amount" => "0",
                        //     "ref" => $dataQr
                        // ]);
                        Linenotify::send("ลูกค้าส่งสลิปเข้ามาในแชต แต่มีมากกว่า 1 คำสั่งซื้อขณะนี้");
                    }
                    $image->delete();
                }
            }
        }
    }
}
