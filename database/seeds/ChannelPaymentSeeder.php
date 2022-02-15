<?php

use Illuminate\Database\Seeder;
use App\Order\ChannelPayment;

class ChannelPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                "id" => 1,
                "text" => "เงินสด",
                "icon" => "attach_money",
                "color" => "green accent-4",
                "status_use" => 1,
            ],
            [
                "id" => 2,
                "text" => "ธนาคาร",
                "icon" => "account_balance",
                "color" => "#003D6B",
                "status_use" => 1,
            ],
            [
                "id" => 3,
                "text" => "KsherPay",
                "icon" => "credit_card",
                "color" => "red accent-4",
                "status_use" => 1,
            ],
            [
                "id" => 99,
                "text" => "อื่น ๆ",
                "icon" => "more_horiz",
                "color" => "deep-purple darken-4",
                "status_use" => 1,
            ],
        ];

        foreach ($datas as $data) {
            $new = new ChannelPayment;
            $new->id = $data["id"];
            $new->text = $data["text"];
            $new->icon = $data["icon"];
            $new->color = $data["color"];
            $new->save();
        }
    }
}
