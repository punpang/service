<?php

use Illuminate\Database\Seeder;
use App\Order\CategoryRelationship;

class OrderCategoryRelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [1, 4], [1, 5],
            [2, 4], [2, 5], [2, 6], [2, 7], [2, 8],
            [3, 4], [3, 5], [3, 6], [3, 7], [3, 8],
            [4, 9],
            [5, 9], [5, 10], [5, 11],
            [6, 9],
            [7, 10],
            [8, 9],
            [8, 10],

        ];

        foreach ($datas as $data) {
            $new = new CategoryRelationship;
            $new->relationship_1 = $data[0];
            $new->relationship_2 = $data[1];
            $new->save();
        }
    }
}
