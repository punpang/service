<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_detail_id');
            $table->foreign('order_detail_id')->references("id")->on("order_details")->onDelete('cascade');
            $table->unsignedBigInteger('category_money_service_id');
            $table->foreign('category_money_service_id')->references("id")->on("category_money_services")->onDelete('cascade');
            $table->double("fee")->default(0);
            $table->integer("thb20")->default(0);
            $table->integer("thb50")->default(0);
            $table->integer("thb100")->default(0);
            $table->integer("thb500")->default(0);
            $table->integer("thb1000")->default(0);
            $table->text("note")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('money_services');
    }
}
