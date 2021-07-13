<?php

use App\ShabuNooNee\PriceRange;
use Illuminate\Database\Seeder;


class PriceRangeSeeder extends Seeder
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
                "title" => "บุฟเฟต์หมู",
                "price_Infant" => 0,
                "price_Children" => 119,
                "price_Adolescence" => 249,
                "price_Adult" => 249,
                "price_Elder" => 119
            ],
            [
                "title" => "บุฟเฟต์หมู+เนื้อวัว",
                "price_Infant" => 0,
                "price_Children" => 149,
                "price_Adolescence" => 299,
                "price_Adult" => 299,
                "price_Elder" => 149
            ],
        ];

        foreach ($datas as $data) {
            PriceRange::create($data);
        }
    }
}
