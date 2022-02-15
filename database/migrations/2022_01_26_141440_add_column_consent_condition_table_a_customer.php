<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class AddColumnConsentConditionTableACustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_customer', function (Blueprint $table) {
            // $table->timestamp('updated_at')->useCurrent();
            $table->boolean("status_consent_condition")->default("0");
            $table->string("status_consent_condition_updated_at")->default(Carbon::now());
            $table->timestamps();
        });
    }

    /**3
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('a_customer', function (Blueprint $table) {
            $table->dropColumn("status_consent_condition");
            $table->dropColumn("status_consent_condition_updated_at");
            $table->dropColumn("created_at");
            $table->dropColumn("updated_at");
        });
    }
}
