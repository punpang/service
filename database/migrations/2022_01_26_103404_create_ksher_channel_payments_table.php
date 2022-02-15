<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKsherChannelPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ksher_channel_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("payment_code");
            $table->string("text");
            $table->string("remark");
            $table->string("color");
            $table->string("image");
            $table->string("image2");
            $table->float("fee_value");
            $table->enum("fee_type", ["bath", "percent"]);
            $table->string("fee_type_th");
            $table->integer("sort");
            $table->boolean("status_use");
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
        Schema::dropIfExists('ksher_channel_payments');
    }
}
