<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicebankdetailsisshow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice_bank_details', function (Blueprint $table) {
            $table->integer('is_show')->default(0)->after('custom_bank_details');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('sale_invoice_bank_details', function (Blueprint $table) {
            $table->dropColumn('is_show')->nullable();
         });
    }
}
