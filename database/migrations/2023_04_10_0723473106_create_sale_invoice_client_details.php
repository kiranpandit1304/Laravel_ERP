<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceclientdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_client_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('name')->nullable();
            $table->string('client_gst_in')->nullable();
            $table->string('client_pan_no')->nullable();
            $table->integer('address_country_id')->nullable();
            $table->integer('address_state_id')->nullable();
            $table->string('address_zip_code')->nullable();
            $table->text('street_address')->nullable();
            $table->string('client_email')->nullable();
            $table->integer('show_email_invoice')->default(0);
            $table->string('client_phone')->nullable();
            $table->integer('show_phone_invoice')->default(0);
            $table->integer('current_changes_business')->default(0);
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
        
         Schema::dropIfExists('sale_invoice_client_details');
    }
}
