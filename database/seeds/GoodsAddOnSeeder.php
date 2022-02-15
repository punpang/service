<?php

use Illuminate\Database\Seeder;
use App\Order\GoodsAddOn;

class GoodsAddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            "แยมสตรอว์เบอร์รี่",
            "แยมมะพร้าวอ่อน",
            "แยมบลูเบอร์รี่",
            "สอดไส้-แยมสตรอว์เบอร์รี่",
            "สอดไส้-แยมมะพร้าวอ่อน",
            "สอดไส้-แยมบลูเบอร์รี่",
        ];

        foreach ($datas as $data) {
            GoodsAddOn::create(
                ["name" => $data]
            );
        }
    }
}
