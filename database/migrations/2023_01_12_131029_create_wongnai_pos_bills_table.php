<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWongnaiPosBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wongnai_pos_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("payment_date");
            $table->text("payment_time");
            $table->string("bill_id")->unique();
            $table->double("total", 2)->default(0);
            $table->text("order_type");
            $table->text("payment_type");
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
        Schema::dropIfExists('wongnai_pos_bills');
    }
}
