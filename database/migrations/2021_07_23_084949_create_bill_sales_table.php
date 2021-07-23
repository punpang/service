<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("dining_table_id")->unique();
            $table->float("total")->default(0);
            $table->float("payment_amount")->default(0);
            $table->float("discount")->default(0);
            $table->float("change")->default(0);
            $table->integer("user_id");
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
        Schema::dropIfExists('bill_sales');
    }
}
