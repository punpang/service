<?php

use App\ShabuNoonee\CookingDetailStatusStep;
use Illuminate\Database\Seeder;

class CookingDetailStatusStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas =
            [
                [
                    "id" => 1,
                    "title" => "รับรายการแล้ว",
                    "key" => "start",
                    "cssClass" => "info"
                ],
                [
                    "id" => 2,
                    "title" => "กำลังจัดเตรียม",
                    "key" => "preparing",
                    "cssClass" => "warning"
                ],
                [
                    "id" => 3,
                    "title" => "เสิร์ฟแล้ว",
                    "key" => "done",
                    "cssClass" => "success"
                ],
            ];

        foreach ($datas as $data) {
            CookingDetailStatusStep::create($data);
        }
    }
}
