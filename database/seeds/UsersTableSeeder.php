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
      return User::create([
          'name' => 'AdminNiCKSiT',
          'email' => 's@gmail.com',
          'phone' => '0864735562',
          'password' => Hash::make('123456'),
          'type' => User::ADMIN_TYPE,
      ]);
    }
}
