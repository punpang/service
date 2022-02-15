<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_add_ons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('goods_add_on_id');
            $table->unsignedBigInteger('am4_id');
            $table->double("price");
            // $table->foreign("a_pirce_id")->references("id")->on("a_price");
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
        Schema::dropIfExists('product_add_ons');
    }
}
