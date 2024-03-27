<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceaddletterhead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sale_invoice_add_letterhead', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->string('letterhead_img')->nullable();
            $table->integer('letterhead_on_first_page')->default(0);
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
        
         Schema::dropIfExists('sale_invoice_add_letterhead');
    }
}
