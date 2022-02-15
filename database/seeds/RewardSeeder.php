<?php

use Illuminate\Database\Seeder;
use App\Order\Reward;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["name" => "ไม่มีรางวัล", "value" => 0],
            ["name" => "เงินคืน", "value" => 100],
            ["name" => "เตารีด", "value" => 399],
            ["name" => "ทองคำ", "value" => 999],
        ];

        foreach($datas as $data)
        {
            $new = new Reward;
            $new->name = $data["name"];
            $new->value = $data["value"];
            $new->save();
        }
    }
}
