<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("table_order_id");
            $table->integer("product_id");
            $table->float("price");
            $table->float("quantity");
            $table->float("sum_price");
            $table->integer("status_free")->default(1);
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
        Schema::dropIfExists('table_order_details');
    }
}
