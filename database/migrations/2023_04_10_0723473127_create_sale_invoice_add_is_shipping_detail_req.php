<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceaddisshippingdetailreq  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->integer('is_shipping_detail_req')->default(0)->after('customer_address');
            $table->integer('is_total_words_show')->default(0)->after('final_total');
            $table->integer('is_contact_show')->default(0)->after('contact_details');
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
            $table->dropColumn('is_shipping_detail_req')->nullable();
            $table->dropColumn('is_total_words_show')->nullable();
            $table->dropColumn('is_contact_show')->nullable();
         });
    }
}
