<?php

use App\ShabuNooNee\DiningTable;
use Illuminate\Database\Seeder;
use App\ShabuNooNee\DiningTableStatus;

class DiningTableStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            "ใช้งานอยู่",
            "ชำระเงิน",
            "ทำความสะอาด",
            "ปิดโต๊ะ"
        ];

        foreach ($datas as $data) {
            $n = new DiningTableStatus;
            $n->title = $data;
            $n->save();
        }
    }
}
