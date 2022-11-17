<?php

use Illuminate\Database\Seeder;
use App\UpdateTableCustomer;
use App\Order\ACustomer;

class updateCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $olds = UpdateTableCustomer::get();

        foreach ($olds as $old) {
            ACustomer::create([
                "id" => $old->id,
                "name" => $old->name,
                "tel" => $old->tel,
                "social" => $old->social,
                "social_is" => $old->social_is,
                "status_consent_condition" => 0
            ]);
        }
    }
}
