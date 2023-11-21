<?php

namespace App\Console\Commands;

use App\Helper;
use App\Linenotify;
// use App\Order\AlertMessages;
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
        // return;
        // เรียกข้อมูล 5 แถวแรก

        $images = FacebookImages::take(5)->get();
        // Linenotify::send($images);
        // return;

        // if ($images->count() > 0) {
        //     Linenotify::send("FacebookImages:AlertPaymentCommand => " . now()->addYears(543)->format('d-m-Y H:i:s'));
        // }

        // นำข้อมูลมาวนลูป
        foreach ($images as $image) {

            // ถ้าเป็นสมาชิก
            // if (isset($image->facebook->customer)) {


            // อ่านคิวอาร์โดยลิงก์ url
            $result = Helper::qrCodeReaderUrl_v2($image->image_url);
            // if ($result == null) {
            //     $image->delete();
            // ถ้ามีข้อมูลคิวอาร์

            if ($result["has_qrcode"] && isset($image->facebook->customer)) {

                // แยกเอาเฉพาะ ref บนสลิป
                // $dataQr = Helper::substr_slip_ref($result["text"]);
                $dataQr = $result["text"];
                // Linenotify::send($dataQr);
                // ค้นหาว่ามี ref นี้หรือยัง
                $is_have = NoticeOfPaymentFromCustomer::where("ref", $dataQr)->first();
                // if (isset($is_have)) {
                //     $image->delete();
                // }


                // ถ้าไม่มี ref ซ่้ำ
                if (empty($is_have)) {

                    // ค้นหารายการสั่งซื้อที่มีเงื่อนไข
                    // สถานะน้อยกว่า 9(รับสินค้า)
                    // ยังไม่เลยกำหนดชำระเงิน
                    // วันที่รับมากกว่าหรือเท่ากับปัจจุบัน
                    // ช่องทางการสั่งซื้อคือ facebook
                    // เรียงลำดับที่อัพเดทล่าสุด
                    $orders = $image->facebook->customer->orders
                        ->where("status", "<", "9")
                        ->where("payment_deadline", ">=", now()->format("Y-m-d H:i:s"))
                        ->where("date_get", ">=", now()->format("Y-m-d"))
                        ->where("channel", "3")
                        ->sortByDesc("updated_at");


                    // มีข้อมูลรายการสั่งซื้อเท่ากับ 1
                    if ($orders->count() == 1) {

                        // เอารายการสั่งซื้อแรก เปลี่ยนตัวแปร
                        $order = $orders->first();

                        // ถ้ายอดคงเหลือมากกว่า 0
                        if ($order->sumBalance() > 0) {
                            // สร้างการแจ้งเตือนชำระเงินจากลูกค้า
                            $notice = NoticeOfPaymentFromCustomer::create([
                                "order_id" => $order->id,
                                "src_name" => $image->image_url,
                                "status" => "create",
                                "amount" => $order->sumBalance(),
                                "ref" => $dataQr
                            ]);
                            // Linenotify::send("รับชำระเงินจากลูกค้า -> #$order->id -> Facebook");

                            //NoticeOfPaymentFromCustomer::setSuccessFromVerifySlip($result["text"], $notice);
                            NoticeOfPaymentFromCustomer::setSuccessFromVerifySlipV3($result["text"], $notice);

                            // แจ้งเตือนไลน์
                        }
                        // AlertMessages::bothNoticeOfPaymentByCustomer($order->id, 0);
                        // AlertMessages::socialNoticeOfPaymentByCustomer($order, 0);
                        $message = "ลูกค้าส่งสลิปเข้ามาในแชต ระบบจัดเก็บเรียบร้อยแล้ว";
                        Linenotify::send($message);
                    }
                    // else if ($orders->count() == 0) {
                    //     $facebook_link = str_starts_with($orders->customer->social_is, "https") ? " -> $orders->customer->social_is" : "";
                    //     Linenotify::send("$facebook_link");
                    // }


                    // มีข้อมูลรายการสั่งซื้อไม่เท่ากับ 1
                    else {
                        $message = $orders->count() == 0 ? "ลูกค้าส่งสลิปเข้ามาในแชต แต่ไม่มีรายการสั่งซื้อรองรับ" : "ลูกค้าส่งสลิปเข้ามาในแชต แต่มีมากกว่า 1 คำสั่งซื้อขณะนี้";
                        Linenotify::send($message);
                    }
                }
            } else if ($result["has_qrcode"] && !isset($image->facebook->customer)) {
                //$message = "ลูกค้าส่งสลิปเข้ามาในแชต แต่ไม่ได้เป็นสมาชิก";
                //Linenotify::send($message);
            }
            // }
            // ลบข้อมูล
            $image->delete();
        }
    }
}
