<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lottery_period_id');
            $table->foreign('lottery_period_id')->references("id")->on("lottery_periods")->onDelete('cascade');
            $table->integer('lucky_number');
            $table->integer('customer_id');
            // $table->unsignedBigInteger('customer_id');
            // $table->foreign('customer_id')->references("id")->on("a_customer")->onDelete('cascade');
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
        Schema::dropIfExists('lottery_registers');
    }
}
