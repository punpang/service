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
            ["name" => "1 ปอนด์", "status" => 1, "product_category_id" => 1],
            ["name" => "2 ปอนด์", "status" => 1, "product_category_id" => 1],
            ["name" => "3 ปอนด์", "status" => 1, "product_category_id" => 1],
            ["name" => "วานิลลา", "status" => 1, "product_category_id" => 2],
            ["name" => "ช็อกโกแลต", "status" => 1, "product_category_id" => 2]
        ];

        foreach($datas as $data){
            ProductCategorySub::create($data);
        }
    }
}
