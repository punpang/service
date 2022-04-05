<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOrderidOrderdetailidDeleteStatususeTableImageFronCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('image_from_customers', function (Blueprint $table) {
            $table->renameColumn("order_id", "order_detail_id");
            $table->dropColumn('status_use');
            $table->softDeletes();
            // $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('image_from_customers', function (Blueprint $table) {
            // $table->dropForeign(["order_detail_id"]);
            $table->dropSoftDeletes();
            $table->boolean("status_use")->default(1);
            $table->renameColumn("order_detail_id", "order_id");
        });
    }
}
