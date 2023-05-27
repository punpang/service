<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipCakeAndSortRelationshipOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            // $table->unsignedBigInteger('a_order_id')->nullable();
            // $table->foreign('a_order_id')->references("id")->on("a_order")->onDelete('cascade');
            $table->integer("order_detail_id")->nullable();
            $table->integer("sort_group_multi_cake")->nullable();
            // $table->text("color_group_multi_cake")->nullable();
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
            $table->dropColumn([
                'order_detail_id',
                'sort_group_multi_cake'
            ]);
        });
    }
}
