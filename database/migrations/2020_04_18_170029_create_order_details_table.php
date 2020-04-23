<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('order')->create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('write_status');
            $table->text('write');
            $table->integer('note_status');
            $table->text('note');
            $table->float('price');            
            $table->integer('quantity')->default('1');
            $table->float('sum_price');
            $table->integer('upload_image_status');
            $table->integer('status')->default('1');
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
        Schema::connection('order')->dropIfExists('order_details');
    }
}
