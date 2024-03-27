<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandIdBaseUnitIdToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_services', function (Blueprint $table) {
            $table->integer('brand_id')->nullable()->after('category_id');
            $table->integer('base_unit_id')->nullable()->after('brand_id');
            $table->integer('sale_unit_id')->nullable()->after('unit_id');
            $table->integer('stock_alert')->nullable()->after('sale_unit_id');
            $table->integer('quantity_limit')->nullable()->after('stock_alert');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_services', function (Blueprint $table) {
            $table->dropColumn('brand_id');
            $table->dropColumn('base_unit_id');
            $table->dropColumn('sale_unit_id');
            $table->dropColumn('stock_alert');
            $table->dropColumn('quantity_limit');
        });
    }
}
