<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorySubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("order")->create('category_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title");
            $table->boolean('status_use')->default(true);
            $table->boolean('switch')->default(false);
            $table->integer('limit')->default(1);
            $table->string("switchClose");
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
        Schema::connection("order")->dropIfExists('category_subs');
    }
}
