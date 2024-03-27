<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createadjustmentitemspractise extends Migration
{
   public function up()
    {
        Schema::create('adjustment_items_practise', function (Blueprint $table) {
            $table->id();
            $table->integer('adjustment_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('variation_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('stock_alert')->nullable();
            $table->string('method_type')->nullable();
            $table->text('custome_field')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('vendor_client_name')->nullable();
            $table->string('adjust_reason')->nullable();
            $table->string('team_id')->nullable();
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
        Schema::dropIfExists('adjustment_items_practise');
    }
}
