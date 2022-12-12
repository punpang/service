<?php

namespace App\Console\Commands;

use App\URL;
use App\Linenotify;
// use App\Order\Facebook;
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
        // $ns = NoticeOfPaymentFromCustomer::whereStatus("success")->get();
        // foreach ($ns as $n) {
        //     if(strlen($n->ref) >= 30){
        //         $output_1 = substr($n->ref, 25);
        //         $ref = substr($output_1, 0, -14);
        //         $n->update(["ref" => $ref]);
        //     }
        // }
        // return Linenotify::send("finished");

        // AlertMessages::LineAlertGeneral("NoticePaymetByCustomerCommand");
        // $ns = NoticeOfPaymentFromCustomer::whereStatus("success")->orderBy("updated_at", "asc")->take(5)->get();
        // if ($ns->count() > 0) {

        //     foreach ($ns as $notice) {
        //         if ($notice->ref != null) {
        //             $curl = curl_init();

        //             curl_setopt_array($curl, array(
        //                 CURLOPT_URL => 'https://api.qrserver.com/v1/read-qr-code/?fileurl=https://lh3.googleusercontent.com/d/' . $notice->src_name . '=w1000-h1000',
        //                 CURLOPT_RETURNTRANSFER => true,
        //                 CURLOPT_ENCODING => '',
        //                 CURLOPT_MAXREDIRS => 10,
        //                 CURLOPT_TIMEOUT => 10,
        //                 CURLOPT_FOLLOWLOCATION => true,
        //                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //                 CURLOPT_CUSTOMREQUEST => 'GET',
        //             ));

        //             $response = curl_exec($curl);

        //             curl_close($curl);


        //             $json = json_decode($response, true);
        //             // Linenotify::send($json[0]["symbol"][0]["data"]);

        //             if (is_null($json[0]["symbol"][0]["data"])) {
        //                 $notice->update(["ref" => $notice->ref]);
        //                 // Linenotify::send($response[0]["symbol"][0]["data"]);
        //             } else {
        //                 $notice->update(["ref" => $json[0]["symbol"][0]["data"]]);
        //             }
        //         }
        //     }
        // }

        $notices = NoticeOfPaymentFromCustomer::whereStatus("create")->get();
        if ($notices->count() > 0) {

            foreach ($notices as $notice) {
                if ($notice->ref == null) {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.qrserver.com/v1/read-qr-code/?fileurl=https://lh3.googleusercontent.com/d/' . $notice->src_name,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 10,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);


                    $json = json_decode($response, true);
                    // Linenotify::send($json[0]["symbol"][0]["data"]);

                    if (is_null($json[0]["symbol"][0]["data"])) {
                        $notice->update(["ref" => "no-qrcode-$notice->id"]);
                        // Linenotify::send($response[0]["symbol"][0]["data"]);
                    } else {
                        $output_1 = substr($json[0]["symbol"][0]["data"], 25);
                        $ref = substr($output_1, 0, -14);

                        $notice_double = NoticeOfPaymentFromCustomer::whereRef($ref)->first();
                        if ($notice_double) {
                            $notice->update(["status" => "cancel"]);
                            Linenotify::send("มีแจ้งชำระเงินซ้ำ หมายเลข #$notice->order_id");
                        } else {
                            $notice->update(["ref" => $ref]);
                        }
                    }
                }
            }
            //  [{"type":"qrcode","symbol":[{"seq":0,"data":"0041000600000101030040220012341130651BPM059845102TH910458A8","error":null}]}]

            $link = URL::base() . "/manages/order/checkNoticeOfPaymentFromCustomer";
            $msgLine = 'รายการแจ้งชำระเงินจากลูกค้า ' . $notices->count() . ' รายการ กำลังรอตรวจสอบ ' . $link;
            AlertMessages::LineAlertGeneral($msgLine);
            return $msgLine;
        }
    }
}
