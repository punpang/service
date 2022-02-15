<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAmAPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_price', function (Blueprint $table) {
            $table->integer("m1");
            $table->integer("m2");
            $table->integer("m3");
            $table->integer("m4");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('a_price', function (Blueprint $table) {
            $table->dropColumn(['m1', 'm2', 'm3', 'm4', 'created_at', 'updated_at']);
        });
    }
}
