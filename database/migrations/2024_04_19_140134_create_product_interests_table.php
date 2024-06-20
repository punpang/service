<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_interests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->integer('pos_goods_id');
            // $table->unsignedBigInteger('customer_id')->nullable();
            // $table->foreign('customer_id')->references("id")->on("a_customer")->onDelete('cascade');
            // $table->unsignedBigInteger('pos_goods_id')->nullable();
            // $table->foreign('pos_goods_id')->references("id")->on("pos_goods")->onDelete('cascade');
            $table->boolean("status_sms_alert")->default(0);
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
        Schema::dropIfExists('product_interests');
    }
}
