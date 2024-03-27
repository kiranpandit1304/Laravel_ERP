<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxChargesHasValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_charges_has_values', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('charges_type_id')->nullable();
            $table->string('charges_type_name')->nullable();
            $table->bigInteger('purchase_sale_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('tax_rate')->nullable();
            $table->string('discount')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('tax_charges_has_values');
    }
}
