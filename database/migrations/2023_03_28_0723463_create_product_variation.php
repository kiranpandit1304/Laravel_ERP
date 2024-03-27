<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation', function (Blueprint $table) {
            $table->id();
            $table->string('variation_name')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable(false)->default("0.00");
            $table->decimal('sale_price', 10, 2)->nullable(false)->default("0.00");
            $table->string('tax_rate')->nullable();
            $table->string('hsn')->nullable();
            $table->integer('unit_id')->nullable();
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
        Schema::dropIfExists('product_variation');
    }
}
