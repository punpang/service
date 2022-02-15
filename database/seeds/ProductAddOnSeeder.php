<?php

use Illuminate\Database\Seeder;
use App\Order\ProductAddOn;

class ProductAddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["goods_add_on_id" => 1, "am4_id" => 1, "price" => 50],
            ["goods_add_on_id" => 1, "am4_id" => 2, "price" => 80],
            ["goods_add_on_id" => 1, "am4_id" => 3, "price" => 100],
            ["goods_add_on_id" => 2, "am4_id" => 1, "price" => 50],
            ["goods_add_on_id" => 2, "am4_id" => 2, "price" => 80],
            ["goods_add_on_id" => 2, "am4_id" => 3, "price" => 100],
            ["goods_add_on_id" => 3, "am4_id" => 1, "price" => 50],
            ["goods_add_on_id" => 3, "am4_id" => 2, "price" => 80],
            ["goods_add_on_id" => 3, "am4_id" => 3, "price" => 100],
            ["goods_add_on_id" => 4, "am4_id" => 1, "price" => 50],
            ["goods_add_on_id" => 4, "am4_id" => 2, "price" => 80],
            ["goods_add_on_id" => 4, "am4_id" => 3, "price" => 100],
            ["goods_add_on_id" => 5, "am4_id" => 1, "price" => 50],
            ["goods_add_on_id" => 5, "am4_id" => 2, "price" => 80],
            ["goods_add_on_id" => 5, "am4_id" => 3, "price" => 100],
            ["goods_add_on_id" => 6, "am4_id" => 1, "price" => 50],
            ["goods_add_on_id" => 6, "am4_id" => 2, "price" => 80],
            ["goods_add_on_id" => 6, "am4_id" => 3, "price" => 100],
        ];

        foreach ($datas as $data) {
            ProductAddOn::create([
                "goods_add_on_id" => $data["goods_add_on_id"],
                "price" => $data["price"],
                "am4_id" => $data["am4_id"],
            ]);
        }
    }
}
