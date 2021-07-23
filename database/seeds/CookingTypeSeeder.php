<?php

use Illuminate\Database\Seeder;
use App\Shabunoonee\CookingType;

class CookingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["id" => 1, "title" => "หม้อชาบู"],
            ["id" => 2, "title" => "เต๋าย่าง"],
        ];

        foreach ($datas as $data) {
            $n = new CookingType;
            $n->id = $data["id"];
            $n->title = $data['title'];
            $n->status = 1;
            $n->save();
        }
    }
}
