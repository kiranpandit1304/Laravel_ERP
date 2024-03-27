<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicelabelchange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_label_change', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->string('label_invoice_no')->nullable();
            $table->string('label_invoice_date')->nullable();
            $table->string('label_invoice_due_date')->nullable();
            $table->string('label_invoice_billed_by')->nullable();
            $table->string('label_invoice_billed_to')->nullable();
            $table->string('label_invoice_shipped_from')->nullable();
            $table->string('label_invoice_shipped_to')->nullable();
            $table->string('label_invoice_transport_details')->nullable();
            $table->string('label_invoice_challan_no')->nullable();
            $table->string('label_invoice_challan_date')->nullable();
            $table->string('label_invoice_transport')->nullable();
            $table->string('label_invoice_extra_information')->nullable();
            $table->string('label_invoice_terms_and_conditions')->nullable();
            $table->string('label_invoice_additional_notes')->nullable();
            $table->string('label_invoice_attachments')->nullable();
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
        
         Schema::dropIfExists('sale_invoice_label_change');
    }
}
