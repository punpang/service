<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order\AlertMessages;
use App\Order\AOrder;

class AlertOrderTodayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Alert:OrderToday';

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
        $datas = AOrder::where('date_get',now()->format("Y-m-d"))->get();
        AlertMessages::lineAlertGeneral("วันนี้มีรายการสั่งซื้อ ".$datas->count()." รายการ");
    }
}
