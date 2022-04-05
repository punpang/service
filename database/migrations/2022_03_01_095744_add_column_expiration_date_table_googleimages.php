<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExpirationDateTableGoogleimages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('google_images', function (Blueprint $table) {
            //$table->dateTime("expiration_date");
            $table->boolean('is_deleted')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('google_images', function (Blueprint $table) {
            $table->dropColumn("is_deleted");
            $table->dropSoftDeletes();
        });
    }
}
