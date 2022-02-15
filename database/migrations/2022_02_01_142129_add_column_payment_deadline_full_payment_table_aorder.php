<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPaymentDeadlineFullPaymentTableAorder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_order', function (Blueprint $table) {
            $table->timestamp("payment_deadline")->nullable();
            $table->boolean("status_full_payment")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('a_order', function (Blueprint $table) {
            $table->dropColumn("payment_deadline");
            $table->dropColumn("status_full_payment");
        });
    }
}
