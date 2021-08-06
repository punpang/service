<?php

use Illuminate\Database\Seeder;
use App\ShabuNoonee\MenuMain;
use App\ShabuNoonee\MenuSub;

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
                // จัดการสินค้า
                "title" => "จัดการสินค้า", "action" => "shop", "admin" => 1, "cashier" => 0, "waitress" => 0, "kitchen" => 0, "customer" => 0,
                "subs" => [
                    ["title" => "สินค้า", "to" => "/admin/product", "admin" => 1, "cashier" => 0, "waitress" => 0, "kitchen" => 0, "customer" => 0],
                    ["title" => "กลุ่มสินค้า", "to" => "/admin/product/group", "admin" => 1, "cashier" => 0, "waitress" => 0, "kitchen" => 0, "customer" => 0]
                ]
            ],
            [
                // จัดการโต๊ะ
                "title" => "จัดการโต๊ะ", "action" => "storefront", "admin" => 1, "cashier" => 1, "waitress" => 0, "kitchen" => 0, "customer" => 1,
                "subs" => [
                    ["title" => "บริหารโต๊ะ", "to" => "/diningtable/manage", "admin" => 1, "cashier" => 1, "waitress" => 0, "kitchen" => 0, "customer" => 0],
                    ["title" => "โต๊ะ", "to" => "/table", "admin" => 0, "cashier" => 0, "waitress" => 0, "kitchen" => 0, "customer" => 1],
                ]


            ],
            [
                // จัดการครัว
                "title" => "จัดการครัว", "action" => "kitchen", "admin" => 0, "cashier" => 0, "waitress" => 0, "kitchen" => 1, "customer" => 0,
                "subs" => [
                    ["title" => "รายการครัว", "to" => "/kitchen/QueueOrder", "admin" => 0, "cashier" => 0, "waitress" => 0, "kitchen" => 1, "customer" => 0],
                ]

            ]
            ,
            [
                // จัดการเสิร์ฟ
                "title" => "จัดการเสิร์ฟ", "action" => "kitchen", "admin" => 0, "cashier" => 0, "waitress" => 1, "kitchen" => 0, "customer" => 0,
                "subs" => [
                    ["title" => "รายการเสิร์ฟ", "to" => "/waitress/QueueOrder", "admin" => 0, "cashier" => 0, "waitress" => 1, "kitchen" => 0, "customer" => 0],
                ]

            ]
        ];



        foreach ($datas as $data) {
            $m = new MenuMain;
            $m->title = $data["title"];
            $m->action = $data["action"];
            $m->admin = $data["admin"];
            $m->cashier = $data["cashier"];
            $m->waitress = $data["waitress"];
            $m->kitchen = $data["kitchen"];
            $m->customer = $data["customer"];
            $m->save();

            foreach ($data["subs"] as $sub) {
                $s = new MenuSub;
                $s->title = $sub["title"];
                $s->to = $sub["to"];
                $s->menu_main_id = $m->id;
                $s->admin = $sub["admin"];
                $s->cashier = $sub["cashier"];
                $s->waitress = $sub["waitress"];
                $s->kitchen = $sub["kitchen"];
                $s->customer = $sub["customer"];
                $s->save();
            }
        }
    }
}
