<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryMoneyServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_money_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("text");
            $table->double("fee")->default(0);
            $table->text("remark")->default("");
            $table->integer("max")->default("99");
            $table->integer("min")->default("1");
            $table->boolean('status_use')->default(1);
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
        Schema::dropIfExists('category_money_services');
    }
}
