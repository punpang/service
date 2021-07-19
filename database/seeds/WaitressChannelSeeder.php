<?php

use Illuminate\Database\Seeder;
use App\ShabuNooNee\WaitressChannel;

class WaitressChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            "ช่องเสิร์ฟที่ 1",
            "ช่องเสิร์ฟที่ 2",
            "ช่องเสิร์ฟที่ 3",
        ];
        foreach ($datas as $data) {
            $new = new WaitressChannel;
;
            $new->title = $data;
            $new->save();
        }
    }
}
