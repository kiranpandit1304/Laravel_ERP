<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicebusinessdetailsadd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_business_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->integer('business_id')->nullable();
            $table->string('business_name')->nullable();
            /*$table->integer('business_country_id')->nullable();
            $table->integer('business_state_id')->nullable();
            $table->string('business_country_name')->nullable();
            $table->string('business_state_name')->nullable();*/
            $table->string('business_gst_in')->nullable();
            $table->string('business_pan_no')->nullable();
            $table->integer('address_country_id')->nullable();
            $table->integer('address_state_id')->nullable();
            $table->string('business_zip_code')->nullable();
            $table->text('street_address')->nullable();
            $table->string('business_email')->nullable();
            $table->integer('show_email_invoice')->default(0);
            $table->string('business_phone')->nullable();
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
        
         Schema::dropIfExists('sale_invoice_business_details');
    }
}
