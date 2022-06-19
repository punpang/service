<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClassTableAStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_status', function (Blueprint $table) {
            $table->text("class")->default("");
            $table->text("group")->default("");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('a_status', function (Blueprint $table) {
            $table->dropColumn("class");
            $table->dropColumn("group");
        });
    }
}
