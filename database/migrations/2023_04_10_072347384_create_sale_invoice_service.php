<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceservice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_service', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->nullable();
            $table->string('guard')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('business_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->string('service_name')->nullable();
            $table->string('service_sale_price')->nullable();
            $table->string('service_item_discount')->nullable();
            $table->string('service_final_price')->nullable();
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
        
         Schema::dropIfExists('sale_invoice_service');
    }
}
