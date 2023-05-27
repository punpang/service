<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartEndTimeToStoreDayOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_day_offs', function (Blueprint $table) {
            $table->time("start_time")->default("00:00:00");
            $table->time("end_time")->default("23:59:59");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_day_offs', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
}
