<?php

namespace App\Console\Commands;

use App\URL;
use App\Order\Facebook;
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
        // AlertMessages::LineAlertGeneral("NoticePaymetByCustomerCommand");
        $notices = NoticeOfPaymentFromCustomer::whereStatus("create")->count();
        if ($notices > 0) {
            $link = URL::base() . "/manages/order/checkNoticeOfPaymentFromCustomer";
            $msgLine = 'รายการแจ้งชำระเงินจากลูกค้า ' . $notices . ' รายการ กำลังรอตรวจสอบ ' . $link;
            AlertMessages::LineAlertGeneral($msgLine);
            return $msgLine;
        }
    }
}
