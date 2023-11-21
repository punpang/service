<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumAlertFacebookStatusPrepareTableAOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_order', function (Blueprint $table) {
            $table->boolean("alert_facebook_by_prepare")->default(0);
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
            $table->dropColumn("alert_facebook_by_prepare");
        });
    }
}
