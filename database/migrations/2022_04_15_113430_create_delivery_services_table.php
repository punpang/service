<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references("id")->on("a_order")->onDelete('cascade');
            $table->string("recipient_name");
            $table->string("recipient_phone");
            $table->double("delivery_fee");
            $table->string("link_google_maps");
            $table->string("detail")->nullable();
            $table->enum('status', ["create", "shipping", "success", "failed"])->default("create");
            $table->string("rider_name")->nullable();
            $table->string("rider_phone")->nullable();
            $table->string("rider_link")->nullable();
            $table->string("delivery_platform")->nullable();
            $table->string("rider_remark")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('delivery_services');
    }
}
