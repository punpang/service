<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsShowPublicTableOrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            //$table->foreignId("a_order_id");
            $table->text("message")->nullable();
            $table->text("detail")->nullable();
            $table->boolean("is_show_public")->default(true);
            $table->unsignedBigInteger("order_id")->change();
            // $table->foreign('order_id')->references('id')->on('a_order')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('is_show_public');
            $table->dropColumn("message");
            $table->dropColumn("detail");
            // $table->dropForeign(["order_id"]);
        });
    }
}
