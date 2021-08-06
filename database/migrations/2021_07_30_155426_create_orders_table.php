<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->integer('promotion_id');
            $table->time('time_get')->nullable();
            $table->float('sum_price_normal');
            $table->float('sum_price_special');
            $table->float('sum_discount');
            $table->integer('status_use')->default(1);
            $table->integer('order_status_id')->default(1);
            $table->string("uuid")->unique();
            $table->string("url");
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
        Schema::dropIfExists('orders');
    }
}
