<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceproductadddescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice_product', function (Blueprint $table) {
            $table->string('product_description')->nullable()->after('product_invoice_details');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('sale_invoice_product', function (Blueprint $table) {
            $table->dropColumn('product_description')->nullable();
         });
    }
}
