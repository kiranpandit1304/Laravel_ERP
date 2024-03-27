<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_id')->nullable()->default('0');
            $table->string('is_return')->nullable()->default('0');
            $table->integer('customer_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->date('sale_date')->nullable();
            $table->integer('sale_number')->nullable()->default('0');
            $table->integer('status')->nullable()->default('0');
            $table->integer('shipping_display')->nullable()->default('1');
            $table->date('send_date')->nullable();
            $table->text('description')->nullable();
            $table->text('discount')->nullable();
            $table->integer('discount_apply')->nullable()->default('0');
            $table->integer('category_id')->nullable();
            $table->integer('created_by')->nullable()->default('0');
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
        Schema::dropIfExists('sales');
    }
}
