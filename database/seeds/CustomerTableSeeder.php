<?php

use Illuminate\Database\Seeder;
use App\Order\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['นิก','0864735562','3487919951224862',''],
            ['แนน','0969611196','','']
        ];

        foreach($datas as $data){
            $new = new Customer;
            $new->name = $data[0];
            $new->phone = $data[1];
            $new->fbid = $data[2];
            $new->psid = $data[3];
            $new->save();
        }
    }
}
