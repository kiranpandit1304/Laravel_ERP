<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentVendorItemsNewFiled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustment_items', function (Blueprint $table) {
            $table->text('custome_field')->nullable()->after('method_type');
            $table->integer('vendor_id')->nullable()->after('custome_field');
            $table->string('adjust_reason')->nullable()->after('vendor_id');
            $table->integer('created_by')->nullable()->after('adjust_reason');
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
            $table->dropColumn('custome_field');
            $table->dropColumn('vendor_id');
            $table->dropColumn('adjust_reason');
            $table->dropColumn('created_by');
        });
    }
}
