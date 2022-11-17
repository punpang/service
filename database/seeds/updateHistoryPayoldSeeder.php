<?php

use Illuminate\Database\Seeder;
use App\UpdateHistoryPayOld;
use App\Order\AHistoryPayed;

class updateHistoryPayoldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = AHistoryPayed::get();
        foreach ($datas as $data) {
            $data->delete();
        }

        $datas = UpdateHistoryPayOld::get();

        foreach ($datas as $data) {
            AHistoryPayed::create([
                "id" => $data->id,
                "id_order" => $data->id_order,
                "user" => $data->user,
                "list" => $data->list,
                "value" => $data->value,
                "billno" => $data->billno,
                "date_time" => $data->date_time,
                "channel_payment_id" => $data->channel_payment_id,
                "status_use" => $data->status_use,
            ]);
        }
    }
}
