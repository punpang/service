<?php

use Illuminate\Database\Seeder;
use App\Order\ProductCategorySub;

class ProductCategorySubTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["id" => "30001", "name" => "1 ปอนด์", "status" => 1, "product_category_id" => 20001],
            ["id" => "30002", "name" => "2 ปอนด์", "status" => 1, "product_category_id" => 20001],
            ["id" => "30003", "name" => "3 ปอนด์", "status" => 1, "product_category_id" => 20001],
            ["id" => "30004", "name" => "วานิลลา", "status" => 1, "product_category_id" => 20002],
            ["id" => "30005", "name" => "ช็อกโกแลต", "status" => 1, "product_category_id" => 20002]
        ];

        foreach ($datas as $data) {
            ProductCategorySub::create($data);
        }
    }
}
