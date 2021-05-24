<?php

use Illuminate\Database\Seeder;
use App\Order\ProductCategory;

class ProductCategoryTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["id"=>"20001","name" => "น้ำหนัก", "status" => 1],
            ["id"=>"20002","name" => "เนื้อเค้ก", "status" => 1]
        ];

        foreach ($datas as $data) {
            ProductCategory::create($data);
        }
    }
}
