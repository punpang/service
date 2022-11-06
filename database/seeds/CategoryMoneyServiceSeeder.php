<?php

use Illuminate\Database\Seeder;
use App\Order\CategoryMoneyService;

class CategoryMoneyServiceSeeder extends Seeder

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
                "text" => "ดึงเงิน",
                "fee" => 100.0,
                "remark" => "สูงสุด 20 แบงค์",
                "max" => 20,
                "min" => 1,
            ],
            [
                "id" => 2,
                "text" => "ล้อมเงิน",
                "fee" => 100.0,
                "remark" => "1:35,2:40,3:45 *ปอนด์:แบงค์*",
                "max" => 45,
                "min" => 35,
            ],
            [
                "id" => 3,
                "text" => "ลูกบอลใส่เงิน",
                "fee" => 100.0,
                "remark" => "สูงสุด 10 แบงค์",
                "max" => 10,
                "min" => 1,
            ],
            [
                "id" => 4,
                "text" => "ซ่อนเงิน",
                "fee" => 100.0,
                "remark" => "สูงสุด 99 แบงค์",
                "max" => 99,
                "min" => 1,
            ],
        ];

        foreach ($datas as $data) {
            CategoryMoneyService::create($data);
        }
    }
}
