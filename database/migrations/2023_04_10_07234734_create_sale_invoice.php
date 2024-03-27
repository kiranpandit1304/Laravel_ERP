<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->nullable();
            $table->string('guard')->nullable();
            $table->integer('business_id')->nullable();
            $table->string('invoice_title')->nullable();
            $table->string('invoice_sub_title')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('due_date')->nullable();
            $table->text('invoice_custome_filed')->nullable();
            $table->string('business_logo')->nullable();
            $table->string('business_logo_name')->nullable();
            $table->text('e_invoice_details')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('shipped_from_name')->nullable();
            $table->integer('shipped_from_country_id')->nullable();
            $table->string('shipped_from_country_name')->nullable();
            $table->text('shipped_from_address')->nullable();
            $table->string('shipped_from_city')->nullable();
            $table->string('shipped_from_zip_code')->nullable();
            $table->string('shipped_from_state_name')->nullable();
            $table->integer('shipped_to_id')->nullable();
            $table->string('shipped_to_name')->nullable();
            $table->integer('shipped_to_country_id')->nullable();
            $table->string('shipped_to_country_name')->nullable();
            $table->text('shipped_to_address')->nullable();
            $table->string('shipped_to_city')->nullable();
            $table->string('shipped_to_zip_code')->nullable();
            $table->string('shipped_to_state_name')->nullable();
            $table->text('shipped_to_custome_filed')->nullable();
            $table->string('currency')->nullable();
            $table->string('final_amount')->nullable();
            $table->string('final_sgst')->nullable();
            $table->string('final_cgst')->nullable();
            $table->string('final_igst')->nullable();
            $table->text('final_product_wise_discount')->nullable();
            $table->text('final_total_discount_reductions')->nullable();
            $table->text('final_extra_charges')->nullable();
            $table->integer('final_summarise_total_quantity')->nullable();
            $table->string('final_total')->nullable();
            $table->text('final_total_words')->nullable();
            $table->text('final_total_more_field')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->text('additional_notes')->nullable();
            $table->text('add_additional_info')->nullable();
            $table->text('contact_details')->nullable();
            $table->string('signature')->nullable();
            $table->string('signature_name')->nullable();
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
        
         Schema::dropIfExists('sale_invoice');
    }
}
