<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('payment_method_id')->default(1);
            $table->float('sum_price')->default(0);
            $table->float('payment_amount')->default(0);
            $table->float('change')->default(0);
            $table->boolean('status_use')->default(1);
            $table->integer('status_payment')->default(1);
            $table->string('image_slip')->nullable();
            $table->string('ref1')->nullable();
            $table->string('ref2')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
