<?php

use App\ShabuNooNee\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
                "title" => "หมูสามชั้นสไลด์",
                "product_group_id" => 1,
                "image_id" => 1,
                "status" => 1,
                "price" => 29,
                "status_free" => 1,
                "next_to" => 4,
            ],
            [
                "title" => "อกไก่",
                "product_group_id" => 2,
                "image_id" => 1,
                "status" => 1,
                "price" => 29,
                "status_free" => 1,
                "next_to" => 4,
            ],
            [
                "title" => "สันนอกหมูสไลด์",
                "product_group_id" => 1,
                "image_id" => 1,
                "status" => 1,
                "price" => 29,
                "status_free" => 1,
                "next_to" => 4,
            ],
            [
                "title" => "น้ำดำ",
                "product_group_id" => 6,
                "image_id" => 1,
                "status" => 1,
                "price" => 29,
                "status_free" => 0,
                "next_to" => 3,
            ],
            [
                "title" => "น้ำต้มยำ",
                "product_group_id" => 6,
                "image_id" => 1,
                "status" => 1,
                "price" => 29,
                "status_free" => 0,
                "next_to" => 3,
            ],
            [
                "title" => "น้ำหม่าล่า",
                "product_group_id" => 6,
                "image_id" => 1,
                "status" => 1,
                "price" => 29,
                "status_free" => 0,
                "next_to" => 3,
            ],
            [
                "title" => "หอยนางรมญี่ปุ่น",
                "product_group_id" => 7,
                "image_id" => 1,
                "status" => 1,
                "price" => 49,
                "status_free" => 0,
                "next_to" => 3,
            ],
        ];

        foreach ($datas as $data) {
            Product::create($data);
        }
    }
}
