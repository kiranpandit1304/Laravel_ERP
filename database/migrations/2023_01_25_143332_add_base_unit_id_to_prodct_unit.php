<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBaseUnitIdToProdctUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_service_units', function (Blueprint $table) {
            $table->integer('base_unit_id')->nullable()->after('name');
            $table->string('short_name')->nullable()->after('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_service_units', function (Blueprint $table) {
            $table->dropColumn('short_name');
            $table->dropColumn('base_unit_id');
        });
    }
}
