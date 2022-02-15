<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("reward_id");
            $table->integer("reward_customer_id")->default(0);
            $table->boolean("status_open")->default(0);
            $table->string("redeem_code", 10)->nullable();
            $table->boolean("status_use_redeem_code")->default(0);
            $table->timestamp("datetime_use_redeem_code")->nullable();
            $table->integer("reward_group_id")->default(1);
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
        Schema::dropIfExists('reward_labels');
    }
}
