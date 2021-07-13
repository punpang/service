<?php

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
                "id" => 1,
                "title" => "หมูสามชั้นสไลด์",
                "product_group_id" => 1,
                "image_id" => 3,
                "status" => 1,
                "created_at" => "2021-07-11 11=>48=>13",
                "updated_at" => "2021-07-11 16=>42=>39",
                "product_group" => [
                    "id" => 1,
                    "name" => "หมู",
                    "status" => 0,
                    "created_at" => "2021-07-11 11=>47=>54",
                    "updated_at" => "2021-07-11 13=>50=>21"
                ],
                "googlg_image" => [
                    "id" => 3,
                    "src_name" => "1KkyhMPomd5EwBXmg3VBc4AQ9TYQ_zANb"
                ]
            ],
            [
                "id" => 2,
                "title" => "อกไก่",
                "product_group_id" => 2,
                "image_id" => 2,
                "status" => 1,
                "created_at" => "2021-07-11 13=>40=>13",
                "updated_at" => "2021-07-11 16=>42=>52",
                "product_group" => [
                    "id" => 2,
                    "name" => "ไก่",
                    "status" => 1,
                    "created_at" => "2021-07-11 13=>39=>18",
                    "updated_at" => "2021-07-11 13=>39=>18"
                ],
                "googlg_image" => [
                    "id" => 2,
                    "src_name" => "19ZUBQRD56a6xOR3HIoIMNSqGM1ILM9pR"
                ]
            ],
            [
                "id" => 3,
                "title" => "สันนอกหมูสไลด์",
                "product_group_id" => 1,
                "image_id" => 4,
                "status" => 1,
                "created_at" => "2021-07-11 18=>30=>42",
                "updated_at" => "2021-07-11 18=>30=>42",
                "product_group" => [
                    "id" => 1,
                    "name" => "หมู",
                    "status" => 0,
                    "created_at" => "2021-07-11 11=>47=>54",
                    "updated_at" => "2021-07-11 13=>50=>21"
                ],
                "googlg_image" => [
                    "id" => 4,
                    "src_name" => "1fq6fH9S_bzDLsAlb1qurOOVXLSEcUMCi"
                ]
            ]
        ];
    }
}
