<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOrderIdForCustomerScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_scores', function (Blueprint $table) {
            // $table->unsignedBigInteger('order_id')->nullable();
            // $table->foreign('order_id')->references("id")->on("a_order")->onDelete('cascade');
            $table->integer("order_id")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_scores', function (Blueprint $table) {
            $table->dropColumn([
                'order_id'
            ]);
        });
    }
}
