<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatecustomersBankDetailsStateName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_bank_details', function (Blueprint $table) {
            $table->string('country_name')->nullable();
            $table->string('state_name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_bank_details', function (Blueprint $table) {
            $table->dropColumn('country_name');
            $table->dropColumn('state_name');
        });
    }
}
