<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAmountTotalFeeTableKsherPay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ksher_pays', function (Blueprint $table) {
            $table->double("amount");
            $table->double("total_fee");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ksher_pays', function (Blueprint $table) {
            $table->dropColumn("amount");
            $table->dropColumn("total_fee");
        });
    }
}
