<?php

use Illuminate\Database\Seeder;
use App\Order\MenuMain;
use App\Order\MenuSub;

class MenuBarSeeder extends Seeder
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
                // จัดการออร์เดอร์
                "title" => "จัดการออร์เดอร์", "action" => "shop", "admin" => 1, "customer" => 0,
                "subs" => [
                    ["title" => "รายการใหม่", "to" => "/manages/order/newOrder", "admin" => 1, "customer" => 0],
                    ["title" => "รายการสั่งซื้อ", "to" => "/manages/order", "admin" => 1, "customer" => 0],
                    ["title" => "ตรวจสอบสลิป", "to" => "/manages/order/checkNoticeOfPaymentFromCustomer", "admin" => 1, "customer" => 0],
                ]
            ],
            [
                // จัดการลุ้นโชค
                "title" => "จัดการลุ้นโชค", "action" => "shop", "admin" => 1, "customer" => 0,
                "subs" => [
                    ["title" => "ลงทะเบียนลุ้นโชค", "to" => "/manages/lucky/register", "admin" => 1, "customer" => 0],
                    ["title" => "แลกของรางวัล", "to" => "/manages/lucky/redeem-code", "admin" => 1, "customer" => 0]
                ]
            ],
            [
                // จัดการ Ksher
                "title" => "KSHER", "action" => "shop", "admin" => 1, "customer" => 0,
                "subs" => [
                    ["title" => "ช่องทางการชำระเงิน", "to" => "/manages/ksher/channel", "admin" => 1, "customer" => 0],
                    ["title" => "วันที่ปิดใช้งาน", "to" => "/manages/ksher/dayOff", "admin" => 1, "customer" => 0],
                ]
            ],
            // [
            //     // จัดการลุ้นโชค
            //     "title" => "จัดการเมนู", "action" => "shop", "admin" => 1, "customer" => 0,
            //     "subs" => [
            //         ["title" => "แลกของรางวัล", "to" => "/manages/lucky/redeem-code", "admin" => 1, "customer" => 0]
            //     ]
            // ],
        ];

        foreach ($datas as $data) {
            $m = new MenuMain;
            $m->title = $data["title"];
            $m->action = $data["action"];
            $m->admin = $data["admin"];
            $m->customer = $data["customer"];
            $m->save();

            foreach ($data["subs"] as $sub) {
                $s = new MenuSub;
                $s->title = $sub["title"];
                $s->to = $sub["to"];
                $s->menu_main_id = $m->id;
                $s->admin = $sub["admin"];
                $s->customer = $sub["customer"];
                $s->save();
            }
        }
    }
}
