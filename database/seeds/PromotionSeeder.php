<?php

use Illuminate\Database\Seeder;
use App\Momday\promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            "title" => "วันแม่",
            "content" => "วันแม่ปีนี้ มอบเค้กพวงมาลัยให้แก่ท่าน",
            "image" => "1EBtRKGu8z6trc3mQyklGpmuc24_XRPUs",
            "date_get" => "2021-08-12",
            "date_start" => "2021-08-01",
            "date_end" => "2021-08-11",
        ];

        promotion::create($datas);
    }
}
