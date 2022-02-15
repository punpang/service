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
    $datas = [
      [
        'name' => 'admin',
        'email' => 'adminnicksit',
        //'phone' => '0864735562',
        'password' => Hash::make('PansitSR4931'),
        'type' => User::ADMIN_TYPE,
        // "type_name" => "admin"
      ],
      [
        'name' => 'testcustomer',
        'email' => 'testcustomer',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        // 'pw' => '123456',
        'type' => 2,
        // "type_name" => "customer"
      ],
    ];

    foreach ($datas as $data) {
      User::create($data);
    }
  }
}
