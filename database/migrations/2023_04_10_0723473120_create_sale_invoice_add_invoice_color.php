<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceaddinvoicecolor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->string('color')->nullable()->after('invoice_pdf');
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
            $table->dropColumn('color')->nullable();
         });
    }
}
