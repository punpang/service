<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("text");
            $table->double("price")->default(0);
            $table->boolean("status_use")->default(true);
            $table->unsignedBigInteger('pos_category_goods_id');
            $table->foreign('pos_category_goods_id')->references("id")->on("pos_category_goods")->onDelete('cascade');
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
        Schema::dropIfExists('goods');
    }
}
