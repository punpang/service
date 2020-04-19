<?php

use Illuminate\Database\Seeder;
use App\Order\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['สร้างรายการสั่งซื้อใหม่','teal accent-1 black--text'], //1
            ['เพิ่มสินค้า','teal accent-3 black--text'],//2
            ['แจ้งยืนยันการสั่งซื้อ','amber accent-2 black--text'],//3
            ['ชำระเงิน','green accent-3 black--text'],//4
            ['ไม่ชำระเงิน','lime accent-2 black--text'],//5
            ['เตรียมสินค้าแล้ว','teal accent-3 black--text'],//6
            ['กำลังจัดส่งสินค้า','light-blue accent-2 black--text'],//7
            ['รับสินค้าแล้ว','success'],//8
            ['ยกเลิกรายการสั่งซื้อ','deep-orange'],//9
        ];

        foreach($datas as $data){
            $new = new OrderStatus;
            $new->name = $data[0];
            $new->style = $data[1];
            $new->save();
        }
    }
}
