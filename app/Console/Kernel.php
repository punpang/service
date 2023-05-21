<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Order\AlertMessages;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // AlertMessages::LineAlertGeneral("TEST Command");

        // แจ้งเตือนชำระเงินจากลูกค้า ที่ส่งสลิปมาในเพจ
        $schedule->command("FacebookImages:AlertPaymentCommand")->everyMinute();

        // แจ้งเตือนชำระเงินจากลูกค้า
        $schedule->command("Alert:NoticePaymentByCustomer")->everyMinute();


        // แจ้งเตือนรายการสั่งซื้อวันนี้
        $schedule->command("Alert:OrderToday")->dailyAt('08:30');
        $schedule->command("Notify:PaymentOfTomorrowOrder")->dailyAt('09:00');


        // สร้างวันที่งดรับชำระผ่าน ksher พฤ-ส
        $schedule->command("create:dayOffsKsher")->dailyAt("22:45");

        // แจ้งเตือนรายการสั่งซื้อที่รอชำระสำหรับวันนี้

        // แจ้งยอดขายวันนี้
        $schedule->command("Alert:SumOrderToday")->everyMinute();

        // ตรวจสอบและเพิ่มคะแนนจากใบเสร็จ wongnai pos
        $schedule->command("ProcessingScore:WongnaiPosBill")->dailyAt('19:15');

        // แจ้งลูกค้าที่ยังไม่ได้รับสินค้า ให้รับก่อนร้านปิด
        $schedule->command("AlertCustomer:GetBeforeClose")->dailyAt('18:00');

        // $schedule->command('inspire')
        //          ->hourly();

        // $schedule->command('queue:listen')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
