<?php

use Illuminate\Database\Seeder;
use App\Order\SlipVerify;

class SlipVerifyTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['รอการตรวจสอบ', 'warning'],
            ['ผ่านการตรวจสอบ', 'success'],
            ['ไม่ผ่านการตรวจสอบ', 'error'],
            ['ตรวจสอบอีกครั้ง', 'warning'],
        ];

        foreach ($datas as $data) {
            $query = new SlipVerify;
            $query->text = $data[0];
            $query->style = $data[1];
            $query->save();
        }
    }
}
