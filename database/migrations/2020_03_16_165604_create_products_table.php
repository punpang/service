<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('order')->create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->float('price_normal')->nullable()->default(0.00);
            $table->boolean('price_special_status')->nullable()->default(false);
            $table->float('price_special')->nullable()->default(0.00);
            $table->boolean('status')->nullable()->default(false);
            $table->boolean('image_status')->nullable()->default(false);
            $table->integer('product_image_id')->nullable()->default('1');
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
        Schema::connection('order')->dropIfExists('products');
    }
}
