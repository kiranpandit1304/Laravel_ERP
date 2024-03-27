<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicebankdetailsbusinessid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice_bank_details', function (Blueprint $table) {
            $table->integer('invoice_id')->default(0)->after('id');
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
            $table->dropColumn('invoice_id')->nullable();
         });
    }
}
