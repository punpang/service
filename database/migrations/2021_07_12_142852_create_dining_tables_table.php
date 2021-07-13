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
            $table->integer("count_Infant");
            $table->integer("count_Children");
            $table->integer("count_Adolescence");
            $table->integer("count_Adult");
            $table->integer("count_Elder");
            $table->dateTime("time_end");
            $table->float("price_Infant");
            $table->float("price_Children");
            $table->float("price_Adolescence");
            $table->float("price_Adult");
            $table->float("price_Elder");
            $table->float("sumPrice");
            $table->integer("priceRange_id");
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
