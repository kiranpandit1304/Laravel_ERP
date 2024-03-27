<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceproductaddproductdiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice_product', function (Blueprint $table) {
            $table->string('product_discount')->nullable()->after('product_amount');
            $table->string('product_discount_type')->nullable()->after('product_discount');
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
            $table->dropColumn('product_discount')->nullable();
            $table->dropColumn('product_discount')->nullable();
         });
    }
}
