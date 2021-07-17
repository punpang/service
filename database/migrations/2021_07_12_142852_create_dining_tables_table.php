<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiningTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dining_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("user_id");
            $table->integer("status_id")->default("1");
            $table->float("count_Infant");
            $table->float("count_Children");
            $table->float("count_Adolescence");
            $table->float("count_Adult");
            $table->float("count_Elder");
            $table->float("sum_customer");            
            $table->dateTime("time_end");
            $table->float("price_Infant");
            $table->float("price_Children");
            $table->float("price_Adolescence");
            $table->float("price_Adult");
            $table->float("price_Elder");
            $table->float("sumPrice");
            $table->integer("priceRange_id");
            $table->uuid('checkAuth');
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
        Schema::dropIfExists('dining_tables');
    }
}
