<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShotlinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shotlinks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('key_link');
            $table->text('url');
            $table->enum('use_for_signin',[0,1])->default(0); // 1 = use
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shotlinks');
    }
}
