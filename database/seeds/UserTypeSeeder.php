<?php

use Illuminate\Database\Seeder;
use App\Order\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['admin', 'customer'];

        foreach ($datas as $data) {
            $query = new UserType;
            $query->name = $data;
            $query->save();
        }
    }
}
