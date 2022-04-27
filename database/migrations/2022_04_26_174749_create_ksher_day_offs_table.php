<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKsherDayOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ksher_day_offs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ksher_channel_payment_id');
            $table->foreign('ksher_channel_payment_id')->references("id")->on("ksher_channel_payments")->onDelete('cascade');
            $table->date('day_off');
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
        Schema::dropIfExists('ksher_day_offs');
    }
}
