<?php

use Illuminate\Database\Seeder;
use App\Order\RewardLabel;

class RewardLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [1,1,1,2,1,1,3,1,1,4];

        foreach($datas as $data){
            $new = new RewardLabel();
            $new->reward_id = $data;
            $new->redeem_code = null;
            $new->save();
        }
    }
}
