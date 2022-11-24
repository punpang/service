<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderImageForMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_image_for_menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_detail_id');
            $table->foreign('order_detail_id')->references("id")->on("order_details")->onDelete('cascade');
            $table->unsignedBigInteger('google_image_id');
            $table->foreign('google_image_id')->references("id")->on("google_images")->onDelete('cascade');
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
        Schema::dropIfExists('order_image_for_menus');
    }
}
