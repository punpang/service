<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMinimumTableKsherChannelPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ksher_channel_payments', function (Blueprint $table) {
            $table->integer("minimum")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ksher_channel_payments', function (Blueprint $table) {
            $table->dropColumn("minimum");
        });
    }
}
