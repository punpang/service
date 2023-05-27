<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkRawMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_link_raw_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_goods_id')->nullable();
            $table->foreign('pos_goods_id')->references("id")->on("pos_goods")->onDelete('cascade');
            $table->unsignedBigInteger('pos_raw_material_id')->nullable();
            $table->foreign('pos_raw_material_id')->references("id")->on("pos_raw_materials")->onDelete('cascade');
            $table->double("weight")->default(0);
            $table->double("cost")->default(0);
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
        Schema::dropIfExists('pos_link_raw_materials');
    }
}
