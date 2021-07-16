<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            UserTypeSeeder::class,
            MenuBarSeeder::class,
            PriceRangeSeeder::class,
            DiningTableStatusSeeder::class,
            ProductGroupSeeder::class

        ]);
    }
}
