<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail_add_ons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("order_detail_id");
            $table->unsignedBigInteger("product_add_on_id");
            $table->double("price");
            $table->boolean("status_use")->default(1);
            $table->timestamps();

            // $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete("cascade");
            // $table->foreign('product_add_on_id')->references('id')->on('product_add_ons')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail_add_ons');
    }
}
