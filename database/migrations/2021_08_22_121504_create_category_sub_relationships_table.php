<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorySubRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("order")->create('category_sub_relationships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_detail_id');
            $table->integer('category_sub_detail_id');
            $table->float('price_normal');
            $table->float('price_special');
            $table->boolean('status_use')->default(1);
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
        Schema::connection("order")->dropIfExists('category_sub_relationships');
    }
}
