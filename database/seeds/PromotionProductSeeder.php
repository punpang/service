<?php

use Illuminate\Database\Seeder;
use App\Momday\PromotionProduct;

class PromotionProductSeeder extends Seeder
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
                "title" => "เค้กพวงมาลัย (สีเหลือง)",
                "image" => "1LeyKhNl6Pf-g0VpHmxhFtQkFRAeMF6NE",
                "price_normal" => "250",
                "price_special" => "219",
                "promotion_id" => "1"
            ],
            [
                "title" => "เค้กพวงมาลัย (สีแดง)",
                "image" => "1QC99pA86psYcyMBR6CN0XlOiyZRHCzbS",
                "price_normal" => "250",
                "price_special" => "219",
                "promotion_id" => "1"
            ],
            [
                "title" => "เค้กพวงมาลัย (สีชมพู)",
                "image" => "1y7oWU-XFYOZCMXrun-SCV-lAvjBSsRyg",
                "price_normal" => "250",
                "price_special" => "219",
                "promotion_id" => "1"
            ],
            [
                "title" => "เค้กพวงมาลัย (สีส้ม)",
                "image" => "1BzaMcqr1c_rc3jm9H5jOllPwYxhElI_j",
                "price_normal" => "250",
                "price_special" => "219",
                "promotion_id" => "1"
            ],
            [
                "title" => "เค้กพวงมาลัย (สีฟ้า)",
                "image" => "1OfW5fuS5c6OdmSlxugb_pO7xTx1uk1Vl",
                "price_normal" => "250",
                "price_special" => "219",
                "promotion_id" => "1"
            ],
            [
                "title" => "เค้กพวงมาลัย (สีม่วง)",
                "image" => "1nKrZ-MVMNeZwjd4FDUUrhD5wN9DkxsJs",
                "price_normal" => "250",
                "price_special" => "219",
                "promotion_id" => "1"
            ],
        ];

        foreach ($datas as $data) {
            PromotionProduct::create($data);
        }
    }
}
