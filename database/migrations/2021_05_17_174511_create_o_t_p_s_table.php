<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOTPSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('o_t_p_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("ref1");
            $table->string("ref2");
            $table->string("phoneNumber");
            $table->boolean("status")->default('0');
            $table->integer("limit")->default("0");
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
        Schema::dropIfExists('o_t_p_s');
    }
}
