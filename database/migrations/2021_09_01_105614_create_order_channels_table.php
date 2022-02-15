<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("order")->create('order_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('keyword')->unique();
            $table->boolean('status_use')->default(true);
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
        Schema::connection("order")->dropIfExists('order_channels');
    }
}
