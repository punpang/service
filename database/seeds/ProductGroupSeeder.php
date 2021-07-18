<?php

use Illuminate\Database\Seeder;
use App\ShabuNooNee\ProductGroup;

class ProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            "หมู", //1
            "ไก่", //2
            "วัว", //3
            "กุ้ง", //4
            "ผัก", //5
            "น้ำซุป", //6
            "อาหารนอกบุฟเฟต์" //7
        ];

        foreach ($datas as $data) {
            $n = new ProductGroup;
            $n->name = $data;
            $n->save();
        }
    }
}
