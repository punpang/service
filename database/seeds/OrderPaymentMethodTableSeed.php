<?php

use Illuminate\Database\Seeder;
use App\Order\OrderPaymentMethod;

class OrderPaymentMethodTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            'เงินสด', //1
            'ธนาคาร', // 2
            'ทรูวอลเลต' // 3
        ];

        foreach($datas as $data){
            $new = new OrderPaymentMethod;
            $new->name = $data;
            $new->status = 1;
            $new->save();
        }
    }
}
