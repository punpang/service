<?php

use Illuminate\Database\Seeder;
use App\Momday\OrderStatus;

class OrderStatusSeeder extends Seeder
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
                "title" => "สร้างรายการสั่งซื้อแล้ว",
                "cssClass" => "info"
            ],
            [
                "id" => 2,
                "title" => "แจ้งชำระเงินแล้ว",
                "cssClass" => "warning"
            ],
            [
                "id" => 3,
                "title" => "สั่งซื้อสำเร็จ",
                "cssClass" => "success"
            ],
            [
                "id" => 4,
                "title" => "เตรียมสินค้าเรียบร้อย",
                "cssClass" => "success"
            ],
            [
                "id" => 5,
                "title" => "รับสินค้าแล้ว",
                "cssClass" => "success"
            ],
            [
                "id" => 6,
                "title" => "ยกเลิกรายการแล้ว",
                "cssClass" => "error"
            ],
        ];

        foreach ($datas as $data) {
            OrderStatus::create($data);
        }
    }
}
