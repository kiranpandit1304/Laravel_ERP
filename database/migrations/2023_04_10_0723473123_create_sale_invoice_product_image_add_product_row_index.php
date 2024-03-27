<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceproductimageaddproductrowindex  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice_product_image', function (Blueprint $table) {
            $table->text('product_row_index')->nullable()->after('invoice_product_image_name');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('sale_invoice_product_image', function (Blueprint $table) {
            $table->dropColumn('product_row_index')->nullable();
         });
    }
}
