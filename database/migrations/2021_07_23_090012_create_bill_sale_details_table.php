<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("bill_sale_id");
            $table->integer("product_id");
            $table->float("price");
            $table->float("quantity");
            $table->float("sum_price");
            $table->integer("status_free")->default(1);
            $table->integer("status")->default(1);
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
        Schema::dropIfExists('bill_sale_details');
    }
}
