<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterWongnaiPosBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_wongnai_pos_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("bill_id")->unique();
            $table->unsignedBigInteger('facebook_id')->nullable();
            $table->foreign('facebook_id')->references("id")->on("facebooks")->onDelete('cascade');
            // $table->unsignedBigInteger('line_id')->nullable();
            // $table->foreign('line_id')->references("id")->on("lines")->onDelete('cascade');
            // $table->unsignedBigInteger('customer_id')->nullable();
            // $table->foreign('customer_id')->references("id")->on("a_customer")->onDelete('cascade');
            $table->unsignedBigInteger('customer_score_id')->nullable();
            $table->foreign('customer_score_id')->references("id")->on("customer_scores")->onDelete('cascade');
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
        Schema::dropIfExists('register_wongnai_pos_bills');
    }
}
