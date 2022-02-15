<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMchOrderNoOfKsherPayTableAHistoryPayed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_history_payed', function (Blueprint $table) {
            $table->string("mch_order_no_of_ksher_pay")->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('a_history_payed', function (Blueprint $table) {
            $table->dropColumn("mch_order_no_of_ksher_pay");
        });
    }
}
