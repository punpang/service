<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountProductInterestTablePosGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_goods', function (Blueprint $table) {
            $table->integer("count_product_interest")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos_goods', function (Blueprint $table) {
            $table->dropColumn("alert_facebook_by_prepare");
        });
    }
}
