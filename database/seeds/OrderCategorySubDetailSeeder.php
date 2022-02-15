<?php

use Illuminate\Database\Seeder;
use App\Order\CategorySubDetail;

class OrderCategorySubDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //     $table->string('title');
        //         $table->integer('category_sub_id');

        // 1    ["ขอบบน","3, 9, 10, 11"],    1
        // 2    ["ขอบข้าง", ""],  2
        // 3    ["ตรงกลาง", "3, 8, 9, 10, 11"],
        // 4    ["ครึ่งหน้า","0, 2, 8, 9, 10, 11"],
        // 5    ["สีครีม","5, 6"],
        // 6    ["สีครีมด้านบน","4"],
        // 7    ["สีครีมด้านข้าง","4"],
        // 8    ["สอดไส้",""],
        // 9    ["รูปภาพ","2, 3, 9, 10, 11"],
        // 10   ["โมเดล","0, 2, 3, 8, 10, 11"],
        // 11   ["มินิมอล","0, 2, 3, 8, 9, 11"],
        // 12    ["ป๊อปอัป", "0, 2, 3, 8, 9, 10"]
        $datas = [
            // 1 ขอบบน 

            ["คิทแคท", 1],
            ["โอริโอ้", 1],
            ["เชอร์รี่", 1],
            ["สตรอว์เบอร์รี่", 1],
            // 2 
            ["ล้อมคิทแคท", 2],
            // 3
            ["แยมมะพร้าวอ่อน", 3],
            ["แยมสตรอว์เบอร์รี่", 3],
            ["แยมบลูเบอร์รี่", 3],
            // 4
            ["ผลไม้รวม", 4],
            ["ขนมทอง", 4],
            // 5
            ["ฟ้า", 5],
            ["แดง", 5],
        ];

        foreach ($datas as $data) {
            $n = new CategorySubDetail;
            $n->title = $data[0];
            $n->category_sub_id = $data[1];
            $n->save();
        }
    }
}
