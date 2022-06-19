<?php

use App\Order\AStatus;
use Illuminate\Database\Seeder;

class AStatusClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id,status,class,group
        $datas = [
            [1, "รับรายการใหม่", "", 1],
            [2, "", "deep-purple darken-1 white--text", 1],
            [3, "", "info", 1],
            [4, "", "warning", 1],
            [8, "", "cyan darken-2", 1],
            [9, "", "success", 1],
            [10, "", "error", 1],
        ];

        foreach ($datas as $data) {
            $u = AStatus::find($data[0]);
            if ($data[1] != "") {
                $u->status = $data[1];
            }
            $u->class = $data[2];
            $u->group = $data[3];
            $u->update();
        }
    }
}
