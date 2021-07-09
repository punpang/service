<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_mains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title");
            $table->string("action")->default(null);
            $table->boolean("admin")->default("1");
            $table->boolean("cashier")->default("0");
            $table->boolean("waitress")->default("0");
            $table->boolean("kitchen")->default("0");
            $table->boolean("customer")->default("0");
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
        Schema::dropIfExists('menu_mains');
    }
}
