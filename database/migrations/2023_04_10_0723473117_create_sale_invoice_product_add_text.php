<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceproductaddtext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice_product', function (Blueprint $table) {
            $table->string('product_hsn_code')->nullable()->after('product_id');
            $table->string('product_gst_rate')->nullable()->after('product_hsn_code');
            $table->string('product_quantity')->nullable()->after('product_gst_rate');
            $table->string('product_rate')->nullable()->after('product_quantity');
            $table->string('product_amount')->nullable()->after('product_rate');
            $table->string('product_igst')->nullable()->after('product_amount');
            $table->string('product_cgst')->nullable()->after('product_igst');
            $table->string('product_sgst')->nullable()->after('product_cgst');
            $table->string('product_total')->nullable()->after('product_sgst');
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
            $table->dropColumn('product_hsn_code')->nullable();
            $table->dropColumn('product_gst_rate')->nullable();
            $table->dropColumn('product_quantity')->nullable();
            $table->dropColumn('product_rate')->nullable();
            $table->dropColumn('product_amount')->nullable();
            $table->dropColumn('product_igst')->nullable();
            $table->dropColumn('product_cgst')->nullable();
            $table->dropColumn('product_sgst')->nullable();
            $table->dropColumn('product_total')->nullable();
         });
    }
}
