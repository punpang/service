<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeGetGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_get_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('promotion_id');
            $table->time('time_get');
            $table->integer("limit_count")->default(6);
            $table->integer("count")->default(0);
            $table->boolean("status_use")->default(1);
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
        Schema::dropIfExists('time_get_goods');
    }
}
