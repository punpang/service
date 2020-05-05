<?php

use Illuminate\Database\Seeder;
use App\Order\SilpUnVerifyReasoning;

class SlipUnVerifyReasoningTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            'สลิปซ้ำกับในระบบ',
            'ไม่มีการชำระเงินอยู่จริง'
        ];

        foreach($datas as $data){
            $n = new SilpUnVerifyReasoning;
            $n->reasoning = $data;
            $n->save();
        }
    }
}
