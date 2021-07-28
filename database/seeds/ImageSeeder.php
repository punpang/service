<?php

use App\ShabuNooNee\GoogleImage;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "src_name" => "1wJqOKOJBi5fH9_cFQNtkZPUbqf7ZR6_S"
        ];

        GoogleImage::create($data);
    }
}
