<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentLinkForUploadImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('order')->create('sent_link_for_upload_images', function (Blueprint $table) {
            $table->integer('order_detail_id')->unique();
            $table->boolean('example')->default(0);
            $table->boolean('image')->default(0);
            $table->string('token')->unique();
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
        Schema::connection('order')->dropIfExists('sent_link_for_upload_images');
    }
}
