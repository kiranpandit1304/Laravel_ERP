<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceqrcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_qr_code', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('qr_color')->nullable();
            $table->string('qr_background_color')->nullable();
            $table->string('qr_logo')->nullable();
            $table->string('qr_image')->nullable();
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
        
         Schema::dropIfExists('sale_invoice_qr_code');
    }
}
