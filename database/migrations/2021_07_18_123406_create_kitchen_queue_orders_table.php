<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenQueueOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_queue_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("queue_id");
            $table->integer("user_id")->default(0);
            $table->integer("format_id")->default(1);
            $table->boolean("status_done")->default(false);
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
        Schema::dropIfExists('kitchen_queue_orders');
    }
}
