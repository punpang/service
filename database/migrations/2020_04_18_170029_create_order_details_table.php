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
            $table->boolean('write_status')->default(0);
            $table->text('write');
            $table->boolean('note_status')->default(0);
            $table->text('note');
            $table->decimal('price',8,2);            
            $table->integer('quantity')->default('1');
            $table->decimal('sum_price',8,2);
            $table->boolean('upload_image_status')->default(0);
            $table->boolean('hide_money')->default(0);
            $table->boolean('permission_to_publish')->default(1);
            $table->string('finished_product_image')->nullable();
            $table->boolean('status')->default(1);
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
