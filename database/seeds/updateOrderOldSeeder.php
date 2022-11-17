<?php

use Illuminate\Database\Seeder;
use App\Order\AOrder;
use App\UpdateOrderOld;
use App\Order\OrderDetail;
use App\Order\APrice;

class updateOrderOldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = AOrder::get();
        foreach ($datas as $data) {
            $data->delete();
        }

        $datas = OrderDetail::get();
        foreach ($datas as $data) {
            $data->delete();
        }

        $datas = UpdateOrderOld::get();
        foreach ($datas as $data) {
            AOrder::create([
                "id" => $data->id,
                "id_customer" => $data->id_customer,
                "date_get" => $data->date_get,
                "time_get" => $data->time_get,
                "status" => $data->status,
                "channel" => 1,
                "date_order" => $data->date_order,
                "auth_order" => $data->auth_order
            ]);


            $price = APrice::where("code", $data->m1 . $data->m2 . $data->m3 . $data->m4)->first();
            if ($price == null) {
                $price = APrice::create([
                    "code" => $data->m1 . $data->m2 . $data->m3 . $data->m4,
                    "price" => $data->total,
                    "m1" => $data->m1,
                    "m2" => $data->m2,
                    "m3" => $data->m3,
                    "m4" => $data->m4
                ]);
            }
            OrderDetail::create([
                "order_id" => $data->id,
                "a_price_id" => $price->id,
                "price" => $data->total,
                "message" => $data->msg,
                "detail" => $data->other
            ]);
        }
    }
}
