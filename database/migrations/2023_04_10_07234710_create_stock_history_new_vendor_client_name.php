<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createstockhistorynewvendorclientname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_history', function (Blueprint $table) {
            $table->string('vendor_client_name')->nullable()->after('vendor_id');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('stock_history', function (Blueprint $table) {
            $table->dropColumn('vendor_client_name')->nullable();
         });
    }
}
