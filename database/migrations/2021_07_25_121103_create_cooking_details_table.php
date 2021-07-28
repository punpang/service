<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooking_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("dining_table_id");
            $table->integer("cooking_type_id")->default(0);
            $table->boolean("status_free")->default(1);
            $table->float("count_of_dining_equipment")->default(0);
            $table->integer("status_step")->default(1);
            $table->boolean("status_use")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cooking_details');
    }
}
