<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("order")->create('category_relationships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('relationship_1');
            $table->integer('relationship_2');
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
        Schema::connection("order")->dropIfExists('category_relationships');
    }
}
