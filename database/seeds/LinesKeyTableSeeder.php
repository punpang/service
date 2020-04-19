<?php

use Illuminate\Database\Seeder;
use App\Linenotify;

class LinesKeyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['VuALSykAt2HiwYKsKuuWGLUEatDyBDmWZWrQFneqNlY','ORDER']
        ];

        foreach($datas as $data){
            $new = new Linenotify;
            $new->key = $data[0];
            $new->target = $data[1];
            $new->save();
        }


    }
}
