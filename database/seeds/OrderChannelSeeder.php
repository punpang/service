<?php

use Illuminate\Database\Seeder;
use App\Order\OrderChannel;

class OrderChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            //[0]id , [1]title , [2]keyword
            [1, "หน้าร้าน", "storefront"],
            [2, "โทรศัพท์", "telephone"],
            [3, "FACEBOOK", "facebook"],
            [4, "LINE", "line"]
        ];

        foreach ($datas as $data) {
            $n = new OrderChannel;
            $n->id = $data[0];
            $n->title = $data[1];
            $n->keyword = $data[2];
            $n->save();
        }
    }
}
