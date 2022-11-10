<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_goods_id');
            $table->foreign('pos_goods_id')->references("id")->on("pos_goods")->onDelete('cascade');
            $table->double("price");
            $table->integer("quantity");
            $table->double("total")->default(0);
            $table->text("note")->nullable();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references("id")->on("a_order")->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('pos_orders');
    }
}
