<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceadvancesetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_advance_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->string('number_format')->nullable();
            $table->string('invoice_country')->nullable();
            $table->string('decimal_digit_format')->nullable();
            $table->string('hide_place_of_supply')->nullable();
            $table->string('hsn_column_view')->nullable();
            $table->string('show_hsn_summary')->nullable();
            $table->string('add_original_images')->nullable();
            $table->string('show_description_in_full_width')->nullable();
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
        
         Schema::dropIfExists('sale_invoice_advance_setting');
    }
}
