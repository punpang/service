<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSlipIdUniqueMchTableAHistorypayed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_history_payed', function (Blueprint $table) {
            $table->unique(["mch_order_no_of_ksher_pay"]);
            $table->integer("notice_of_payment_from_customer_id")->unique()->nullable();
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
            $table->dropColumn('notice_of_payment_from_customer_id');
        });
    }
}
