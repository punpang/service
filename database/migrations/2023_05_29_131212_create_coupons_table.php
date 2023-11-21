<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("title");
            $table->text("code");
            $table->double("minimum")->default(0);
            $table->double("maximum")->default(0);
            $table->double("percent")->default(100);
            $table->date("date_start");
            $table->date("date_end");
            $table->integer("limit_times")->default(1);
            $table->integer("used_times")->default(0);
            $table->integer("customer_id")->nullable();
            // $table->unsignedBigInteger('a_customer_id')->nullable();
            // $table->foreign('a_customer_id')->references("id")->on("a_customer")->onDelete('cascade');
            $table->text("remark")->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
