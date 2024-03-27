<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceaddpayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_add_payment', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->string('amount_received')->nullable();
            $table->string('tds_percentage')->nullable();
            $table->string('tds_amount')->nullable();
            $table->string('tcs_percentage')->nullable();
            $table->string('tcs_amount')->nullable();
            $table->string('amount_to_settle')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('additional_notes')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('payment_status')->nullable();
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
        
         Schema::dropIfExists('sale_invoice_add_payment');
    }
}
