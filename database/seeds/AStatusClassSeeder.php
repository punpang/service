<?php

use App\Order\AStatus;
use Illuminate\Database\Seeder;

class AStatusClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id,status,class,group
        $datas = [
            [1, "รับรายการใหม่", "", 1],
            [2, "รอยืนยันคำสั่งซื้อ", "deep-purple darken-1 white--text", 1],
            [3, "ยืนยันคำสั่งซื้อ", "info", 1],
            [4, "รอจัดเตรียมสินค้า", "warning", 1],
            [8, "เตรียมสินค้าเรียบร้อย", "cyan darken-2 white--text", 1],
            [9, "รับสินค้าเรียบร้อย", "success", 1],
            [10, "ยกเลิกคำสั่งซื้อ", "error", 1],
        ];

        foreach ($datas as $data) {
            $u = AStatus::find($data[0]);
            $u->status = $data[1];
            $u->class = $data[2];
            $u->group = $data[3];
            $u->update();
        }
    }
}
