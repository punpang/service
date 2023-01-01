<?php

namespace App\Console\Commands;

use App\URL;
use App\Helper;
// use App\Order\Facebook;
use App\Linenotify;
use App\Order\AOrder;
use App\Order\Setting;
use App\order\AHistoryPayed;
use App\Order\AlertMessages;
use Illuminate\Console\Command;
use App\Order\NoticeOfPaymentFromCustomer;

class NoticePaymetByCustomerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Alert:NoticePaymentByCustomer';

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
        $notices = NoticeOfPaymentFromCustomer::whereStatus("create")->take(10)->get();
        $count_verify_slip = 0;
        if ($notices->count() > 0) {

            foreach ($notices as $notice) {

                if (is_null($notice->ref)) {
                    if (str_starts_with($notice->src_name, "http")) {
                        $url = $notice->src_name;
                    } else {
                        $url = "https://lh3.googleusercontent.com/d/$notice->src_name";
                    }

                    $result =  Helper::qrCodeReaderUrl_v2($url);

                    // Linenotify::send($result);

                    if ($result["has_qrcode"]) {
                        // $ref = Helper::substr_slip_ref($result["text"]);
                        $ref = $result["text"];
                        $notice_double = NoticeOfPaymentFromCustomer::whereRef($ref)->first();
                        if ($notice_double) {
                            NoticeOfPaymentFromCustomer::setCancel($notice);
                            Linenotify::send("มีแจ้งชำระเงินซ้ำ หมายเลข #$notice->order_id");
                        } else {
                            $notice->update(["ref" => $ref]);
                            $setSuccessFromVerifySlip = NoticeOfPaymentFromCustomer::setSuccessFromVerifySlip($result["text"], $notice);
                            if ($setSuccessFromVerifySlip["success"]) {
                                $count_verify_slip = $count_verify_slip + 1;
                            }
                        }
                    } else {
                        $notice->update(["ref" => "no-qrcode-$notice->id"]);
                        // Linenotify::send($response[0]["symbol"][0]["data"]);
                    }
                }
            }
            //  [{"type":"qrcode","symbol":[{"seq":0,"data":"0041000600000101030040220012341130651BPM059845102TH910458A8","error":null}]}]

            $setting = Setting::first();
            // 18:43 <= 19:00 /
            // 18:43 >= 08:30 /
            $is_time_close_store = now()->format("H:i") <= $setting->close_store && now()->format("H:i") >= $setting->open_store;
            if ($is_time_close_store && ($notices->count() - $count_verify_slip) > 0) {
                $link = URL::base() . "/manages/order/checkNoticeOfPaymentFromCustomer";
                $msgLine = 'รายการแจ้งชำระเงินจากลูกค้า ' . ($notices->count() - $count_verify_slip) . ' รายการ กำลังรอตรวจสอบ ' . $link;
                AlertMessages::LineAlertGeneral($msgLine);
            }

            return;
        }
    }
}
