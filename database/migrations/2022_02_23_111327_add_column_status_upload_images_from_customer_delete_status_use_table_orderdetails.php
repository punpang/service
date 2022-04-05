<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusUploadImagesFromCustomerDeleteStatusUseTableOrderdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('status_use');
            $table->dropColumn("is_show_public");
            $table->boolean("status_upload_images_from_customer")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn("status_upload_images_from_customer");
            $table->boolean("is_show_public")->default(1);
            $table->boolean("status_use")->default(1);
        });
    }
}
