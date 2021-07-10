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
            "หมู", "ไก่", "วัว", "กุ้ง", "ผัก"
        ];

        foreach ($datas as $data) {
            $n = new ProductGroup;
            $n->name = $data;
            $n->save();
        }
    }
}
