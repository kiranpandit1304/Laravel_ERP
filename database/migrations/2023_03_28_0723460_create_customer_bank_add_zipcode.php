<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBankAddzipcode extends Migration
{
    public function up()
    {
        Schema::table('customer_bank_details', function (Blueprint $table) {
            $table->string('zip_code')->nullable()->after('state_id');
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
            $table->dropColumn('zip_code');
        });
    }
}
