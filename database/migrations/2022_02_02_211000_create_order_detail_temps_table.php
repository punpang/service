<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_temp_id');
            $table->text('temp');
            // $table->foreign("order_temp_id")->references("id")->on("order_temps");
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
        Schema::dropIfExists('order_detail_temps');
    }
}
