<?php

use Illuminate\Database\Seeder;
use App\Order\CategoryType;

class OrderCategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["id" => 1, "title" => "รายการหลัก"],
            ["id" => 2, "title" => "รายการรอง"]
        ];

        foreach ($datas as $data) {
            CategoryType::create($data);
        }
    }
}
