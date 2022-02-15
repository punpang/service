<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('order')->create('category_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->float('price_normal');
            $table->float('price_special');
            $table->integer('category_id');
            // $table->integer("category_type_id");
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
        Schema::connection('order')->dropIfExists('category_details');
    }
}
