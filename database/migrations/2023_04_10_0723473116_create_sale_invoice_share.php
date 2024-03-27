<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceshare extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_share', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->string('mesg_type')->nullable();
            $table->string('recipient')->nullable();
            $table->string('mobile_no')->nullable();
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
        
         Schema::dropIfExists('sale_invoice_share');
    }
}