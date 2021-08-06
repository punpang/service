<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaitressQueueOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waitress_queue_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("dining_table_id");
            $table->integer("queue_id");
            $table->integer("user_id")->default(0);
            $table->integer("waitress_channal")->default(0);
            $table->integer("format_id")->default(1);
            $table->boolean("status_done")->default(false);
            $table->boolean("status_use")->default(true);
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
        Schema::dropIfExists('waitress_queue_orders');
    }
}
