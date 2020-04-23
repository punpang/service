<?php

use Illuminate\Database\Seeder;
use App\Order\Product;
use App\Order\ProductImage;
use App\Order\ProductTag;

class ProductTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ["name" => "ฝอยทอง", "price_normal" => 200, "price_special_status" => 0, "price_special" => 200, "status" => 1, "image_status" => 1, "product_image_id" => 1],
            ["name" => "มะพร้าวอ่อน", "price_normal" => 420, "price_special_status" => 1, "price_special" => 370, "status" => 1, "image_status" => 1, "product_image_id" => 2]
        ];
        $images = [
            ["src_name" => "1xjCwaYTe66X_RZjrty0gOZSp2gxvRdYF"],
            ["src_name" => "1edh4NiynD2TXzHa_g47epABTKgby_BQu"]
        ];

        $tags = [
            ["product_id" => 1, "product_category_sub_id" => 1, "status" => 1],
            ["product_id" => 1, "product_category_sub_id" => 4, "status" => 1],
            ["product_id" => 2, "product_category_sub_id" => 2, "status" => 1],
            ["product_id" => 2, "product_category_sub_id" => 4, "status" => 1]
        ];

        foreach ($products as $data) {
            Product::create($data);
        }

        foreach ($images as $data) {
            ProductImage::create($data);
        }

        foreach ($tags as $data) {
            ProductTag::create($data);
        }
    }
}
