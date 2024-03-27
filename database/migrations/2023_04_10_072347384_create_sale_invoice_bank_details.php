<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicebankdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_bank_details', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('currency')->nullable();
            $table->string('account_type')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->text('custom_bank_details')->nullable();
            $table->string('upi_id')->nullable();
            $table->integer('team_id')->nullable();
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
        
         Schema::dropIfExists('sale_invoice_bank_details');
    }
}
