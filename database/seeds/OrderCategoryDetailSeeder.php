<?php

use Illuminate\Database\Seeder;
use App\Order\CategoryDetail;

class OrderCategoryDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["title" => "1 ปอนด์", "price_normal" => 200, "price_special" => 150,  "category_id" => 1],
            ["title" => "2 ปอนด์", "price_normal" => 400, "price_special" => 300, "category_id" => 1],
            ["title" => "3 ปอนด์", "price_normal" => 600, "price_special" => 350, "category_id" => 1],
            //   
            ["title" => "วานิลลา", "price_normal" => 0, "price_special" => 0, "category_id" => 2],
            ["title" => "ช็อกโกแล็ต", "price_normal" => 30, "price_special" => 30, "category_id" => 2],
            ["title" => "ใบเตย", "price_normal" => 30, "price_special" => 30, "category_id" => 2],
            ["title" => "ส้ม", "price_normal" => 30, "price_special" => 30, "category_id" => 2],
            ["title" => "กาแฟ", "price_normal" => 30, "price_special" => 30, "category_id" => 2],
            //
            ["title" => "ครีมนมสด", "price_normal" => 0, "price_special" => 0, "category_id" => 3],
            ["title" => "หน้านิ่ม", "price_normal" => 20, "price_special" => 20, "category_id" => 3],
            ["title" => "กานาช", "price_normal" => 40, "price_special" => 40, "category_id" => 3],
            //
            // ["title" => "ทั่วไป", "price_normal" => 0, "price_special" => 0, "category_id" => 3, "category_type_id" => 1],
            // ["title" => "รูปภาพ", "price_normal" => 0, "price_special" => 0, "category_id" => 3, "category_type_id" => 1],
            // ["title" => "ป๊อปอัป", "price_normal" => 0, "price_special" => 0, "category_id" => 3, "category_type_id" => 1],
            // ["title" => "โมเดล", "price_normal" => 0, "price_special" => 0, "category_id" => 3, "category_type_id" => 1],
        ];

        foreach ($datas as $data) {
            CategoryDetail::create($data);
        }
    }
}
