<?php

use Illuminate\Database\Seeder;
use App\Order\Category;

class OrderCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["id" => 1, "title" => "ขนาด", "next" => 2],
            ["id" => 2, "title" => "เนื้อเค้ก", "next" => 3],
            ["id" => 3, "title" => "รูปแบบ", "next" => 4],
            ["id" => 4, "title" => "ตกแต่ง", "next" => 5]
        ];

        foreach ($datas as $data) {
            Category::create($data);
        }
    }
}
