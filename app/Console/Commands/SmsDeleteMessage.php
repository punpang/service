<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SendSmsAgain;


class SmsDeleteMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sms:DeleteMessage';

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
        SendSmsAgain::where("created_at", "<=", now()->subMinutes(10))
        ->delete();

        return;
    }
}
