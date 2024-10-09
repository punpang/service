<?php

namespace App\Console\Commands;

use App\MSms;
use App\SendSmsAgain;
use Illuminate\Console\Command;
use App\Order\StoreDayOff;


class SmsSendAgain extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sms:SendAgain';

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

        $is_day_off = StoreDayOff::isDayOff();
        if ($is_day_off["status"]) {
            return "ร้านปิด";
        }

        // 10:30
        // 2024-09-30 10:25:31 <= 10:20:00
        $data = SendSmsAgain::first();

        if (isset($data)) {
            $result = MSms::Sms($data->phone, $data->message);
            if ($result["success"]) {
                $data->delete();
            }
        }

        return;

        // $datas = SendSmsAgain::take(5)->get();

        // foreach ($datas as $data) {
        //     $result = MSms::Sms($data->phone, $data->message);
        //     if ($result["success"]) {
        //         $data->delete();
        //     }else{
        //         return ;
        //     }
        // }
        // return;
    }
}
