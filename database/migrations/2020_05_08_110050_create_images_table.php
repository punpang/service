<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('order')->create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_detail_id');
            $table->string('public_id');
            $table->string('url');
            $table->enum('type',['example','images']);
            $table->boolean("main")->default(0);
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
        Schema::connection('order')->dropIfExists('images');
    }
}
