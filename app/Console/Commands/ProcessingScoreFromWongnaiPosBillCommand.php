<?php

namespace App\Console\Commands;

// use App\Linenotify;
// use App\Order\AlertMessages;
use App\Order\CustomerScore;
use App\Order\WongnaiPosBills;
use Illuminate\Console\Command;
use App\Order\RegisterWongnaiPosBill;

class ProcessingScoreFromWongnaiPosBillCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ProcessingScore:WongnaiPosBill';

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
        $null_register_bills = RegisterWongnaiPosBill::whereNull("customer_score_id")->get();

        foreach ($null_register_bills as $null_register_bill) {
            $wongnai_pos_bill =  WongnaiPosBills::where("bill_id", $null_register_bill->bill_id)
                ->whereIn("payment_type", ["Cash", "โอนเงิน", "E-Payment", "UnionPay", "Split Amount"])
                ->first();
            if ($wongnai_pos_bill) {
                if ($wongnai_pos_bill->payment_date_time > $null_register_bill->created_at) {
                    // return $wongnai_pos_bill;
                    // $score = "";
                    switch ($wongnai_pos_bill->order_type) {
                        case 'Dine-In':
                            $score = CustomerScore::addScore(
                                $null_register_bill->facebook->customer,
                                $wongnai_pos_bill->total,
                                0,
                                null,
                                365,
                                false
                            );
                            break;
                        case 'Delivery':
                            if ($wongnai_pos_bill->payment_type == "E-Payment") {
                                $amount = $wongnai_pos_bill->total * 65 / 100;
                            } else {
                                $amount = $wongnai_pos_bill->total;
                            }
                            $score = CustomerScore::addScore(
                                $null_register_bill->facebook->customer,
                                $amount,
                                0,
                                null,
                                365,
                                false
                            );
                            break;
                        default:
                            # code...
                            break;
                    }
                    // return $score;
                    if ($score["status"] == "success") {
                        $null_register_bill->update([
                            "customer_score_id" => $score["score"]["id"]
                        ]);
                        // AlertMessages::smsAddScoreWongnaiPosBill($null_register_bill->facebook->customer, $score["score"]["point"]);
                    }
                } else {
                    $null_register_bill->delete();
                }
            }
        }
    }
}
