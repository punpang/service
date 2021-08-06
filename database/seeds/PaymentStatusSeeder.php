<?php

use Illuminate\Database\Seeder;
use App\Momday\PaymentStatus;

class PaymentStatusSeeder extends Seeder
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
                "title" => "รอการตรวจสอบ",
                "cssClass" => "warning"
            ],
            [
                "id" => 2,
                "title" => "ชำระเงินแล้ว",
                "cssClass" => "success"
            ],
            [
                "id" => 3,
                "title" => "ไม่ผ่านการตรวจสอบ",
                "cssClass" => "error"
            ],
        ];

        foreach ($datas as $data) {
            PaymentStatus::create($data);
        }
    }
}
