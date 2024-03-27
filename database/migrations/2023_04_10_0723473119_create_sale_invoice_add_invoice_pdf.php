<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceaddinvoicepdf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->string('invoice_pdf')->nullable()->after('signature_name');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->dropColumn('invoice_pdf')->nullable();
         });
    }
}
