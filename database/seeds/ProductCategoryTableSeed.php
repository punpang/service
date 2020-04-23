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
        $datas = [["name" => "น้ำหนัก", "status" => 1], ["name" => "เนื้อเค้ก", "status" => 1]];

        foreach ($datas as $data) {
            ProductCategory::create($data);
        }
    }
}
