<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("order")->create('category_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_relationship_id');
            $table->float('price_normal');
            $table->float('price_special');
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
        Schema::connection("order")->dropIfExists('category_prices');
    }
}
