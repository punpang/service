<?php

use Illuminate\Database\Seeder;
use App\Order\CategorySub;

class OrderCategorySubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            // [title [0] , switchClose[1]]
            ["ขอบบน","3, 9, 10, 11"],
            ["ขอบข้าง", ""],
            ["ตรงกลาง", "3, 8, 9, 10, 11"],
            ["ครึ่งหน้า","0, 2, 8, 9, 10, 11"],
            ["สีครีม","5, 6"],
            ["สีครีมด้านบน","4"],
            ["สีครีมด้านข้าง","4"],
            ["สอดไส้",""],
            ["รูปภาพ","2, 3, 9, 10, 11"],
            ["โมเดล","0, 2, 3, 8, 10, 11"],
            ["มินิมอล","0, 2, 3, 8, 9, 11"],
            ["ป๊อปอัป", "0, 2, 3, 8, 9, 10"]
        ];

        foreach ($datas as $data) {
            $new = new CategorySub;
            $new->title = $data[0];
            $new->switchClose = $data[1];
            $new->save();
        }
    }
}
