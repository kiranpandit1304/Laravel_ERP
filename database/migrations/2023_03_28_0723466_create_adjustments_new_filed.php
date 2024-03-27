<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentsNewFiled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustments', function (Blueprint $table) {
            $table->string('vendor_id')->nullable()->after('reference_code');
            $table->string('adjust_reason')->nullable()->after('vendor_id');
            $table->text('custome_field')->nullable()->after('reference_code');
            $table->text('created_by')->nullable()->after('total_products');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('adjustments', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
            $table->dropColumn('adjust_reason');
            $table->dropColumn('custome_field');
            $table->dropColumn('created_by');
        });
    }
}
