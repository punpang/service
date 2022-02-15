<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChannelidStatususeAhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_history_payed', function (Blueprint $table) {
            $table->integer("channel_payment_id")->default("1");
            $table->boolean("status_use")->default(true);            
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
            $table->dropColumn("channel_payment_id");
            $table->dropColumn("status_use");
        });
    }
}
