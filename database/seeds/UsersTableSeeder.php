<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = User::get();
        foreach ($datas as $data) {
            $data->delete();
        }

        $datas = [
            [
                "id" => 1,
                'name' => 'admin',
                'email' => 'adminnicksit',
                //'phone' => '0864735562',
                'password' => Hash::make('PansitSR4931'),
                'type' => User::ADMIN_TYPE,
                // "type_name" => "admin"
            ],
            [
                "id" => 2,
                'name' => 'nan',
                'email' => 'nan',
                //'phone' => '0864735562',
                'password' => Hash::make('291727'),
                // 'pw' => '123456',
                'type' => User::ADMIN_TYPE,
                // "type_name" => "customer"
            ],
            [
                "id" => 3,
                'name' => 'mana',
                'email' => 'mana',
                //'phone' => '0864735562',
                'password' => Hash::make('292717'),
                // 'pw' => '123456',
                'type' => User::ADMIN_TYPE,
                // "type_name" => "customer"
            ],
        ];

        foreach ($datas as $data) {
            User::create($data);
        }
    }
}
