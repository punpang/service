<?php

use Illuminate\Database\Seeder;
use App\Order\ChannelOfPurchase;

class ChannelOfPurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['หน้าร้าน', 'FACEBOOK', 'LINE', 'โทรศัพท์'];

        foreach ($datas as $data) {
            $query = new ChannelOfPurchase;
            $query->name = $data;
            $query->status = '1';
            $query->save();
        }
    }
}
