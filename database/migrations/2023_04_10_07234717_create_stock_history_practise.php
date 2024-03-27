<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createstockhistorypractise extends Migration
{
   public function up()
    {
        Schema::create('stock_history_practise', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('vendor_client_name')->nullable();
            $table->text('custome_field')->nullable();
            $table->text('adjust_reason')->nullable();
            $table->date('stock_date')->nullable();
            $table->string('user_type')->nullable();
            $table->integer('variation_id')->nullable();
            $table->string('variation_name')->nullable();
            $table->string('stock')->nullable();
            $table->string('method_type')->nullable();
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
        Schema::dropIfExists('stock_history_practise');
    }
}
