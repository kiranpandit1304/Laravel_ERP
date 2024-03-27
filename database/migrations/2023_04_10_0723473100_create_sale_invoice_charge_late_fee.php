<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicechargelatefee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_charge_late_fee', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->integer('enable_late')->default(0);
            $table->integer('show_in_invoice')->default(0);
            $table->string('fee_type')->nullable();
            $table->string('fee_amount')->nullable();
            $table->string('days_after_due_date')->nullable();
            $table->string('tax_rate')->nullable();
            $table->string('hsn_code')->nullable();            
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
        
         Schema::dropIfExists('sale_invoice_charge_late_fee');
    }
}
