<?php

namespace App\Console\Commands;

use App\Linenotify;
use App\Order\KsherDayOff;
use Illuminate\Console\Command;

class CreateDayOffsKsher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:dayOffsKsher';

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
        // 0 อาทิตย์
        // 1 จันทร์
        // 2 อังคาร
        // 3 พุธ
        // 4 พฤหัสดี
        // 5 ศุกร์
        // 6 เสาร์

        $dayOffs = [4,5,6];
        $kshers = [1,2,3,4,7];

        //$day = now()->isoFormat("dddd");
        foreach ($dayOffs as $dayOff) {
            if(now()->addDays(1)->isoFormat("d") == $dayOff){
                foreach ($kshers as $ksher){
                    KsherDayOff::create([
                        "ksher_channel_payment_id" => $ksher,
                        "day_off" => now()->addDays(1)->format("Y-m-d")
                    ]);
                }
            }
        }
        Linenotify::send("เพิ่มวันหยุดรับชำระช่องทาง Ksher แล้ว");
    }
}
