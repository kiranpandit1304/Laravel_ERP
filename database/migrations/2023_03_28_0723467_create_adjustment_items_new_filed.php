<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentItemsNewFiled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustment_items', function (Blueprint $table) {
            $table->string('variation_id')->nullable()->after('product_id');
            $table->string('stock_alert')->nullable()->after('quantity');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('adjustment_items', function (Blueprint $table) {
            $table->dropColumn('variation_id');
            $table->dropColumn('stock_alert');
        });
    }
}
