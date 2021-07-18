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
        'name' => 'AdminNiCKSiT',
        'email' => 'admin',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'type' => User::ADMIN_TYPE,
      ],
      [
        'name' => 'โต๊ะที่ 1',
        'email' => 'table1',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'pw' => '123456',
        'type' => 5,
      ],
      [
        'name' => 'โต๊ะที่ 2',
        'email' => 'table2',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'pw' => '123456',
        'type' => 5,
      ],
      [
        'name' => 'โต๊ะที่ 3',
        'email' => 'table3',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'pw' => '123456',
        'type' => 5,
      ],
      [
        'name' => 'โต๊ะที่ 4',
        'email' => 'table4',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'pw' => '123456',
        'type' => 5,
      ],
      [
        'name' => 'โต๊ะที่ 5',
        'email' => 'table5',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'pw' => '123456',
        'type' => 5,
      ]
      ,
      [
        'name' => 'โต๊ะที่ 6',
        'email' => 'table6',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'pw' => '123456',
        'type' => 5,
      ]
      ,
      [
        'name' => 'โต๊ะที่ 7',
        'email' => 'table7',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'pw' => '123456',
        'type' => 5,
      ]
      ,
      [
        'name' => 'โต๊ะที่ 8',
        'email' => 'table8',
        //'phone' => '0864735562',
        'password' => Hash::make('123456'),
        'pw' => '123456',
        'type' => 5,
      ]
    ];

    foreach ($datas as $data) {
      User::create($data);
    }
  }
}
