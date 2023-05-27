<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_periods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date("date");
            $table->integer('result')->nullable();
            $table->integer('cumulative_reward')->default(0);
            $table->boolean('is_awarded')->default(false);
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
        Schema::dropIfExists('lottery_periods');
    }
}
