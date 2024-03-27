<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createadjustmentitemsnewvendorclientname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustment_items', function (Blueprint $table) {
            $table->integer('vendor_client_name')->nullable()->after('vendor_id');
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
            $table->dropColumn('vendor_client_name')->nullable();
         });
    }
}
