<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceprovideeinvoicedetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_provide_e_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->string('gstin')->nullable();
            $table->string('gsp_username')->nullable();
            $table->string('gsp_password')->nullable();
            $table->integer('save_credentials_browser_only')->default(0);
            $table->integer('save_credentials_across_all')->default(0);
            $table->integer('created_by')->nullable();
            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
         Schema::dropIfExists('sale_invoice_provide_e_invoice_details');
    }
}
