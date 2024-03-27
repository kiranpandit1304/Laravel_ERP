<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createstockhistorynewcustomefiled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_history', function (Blueprint $table) {
            $table->text('custome_field')->nullable()->after('vendor_client_name');
            $table->text('adjust_reason')->nullable()->after('custome_field');
            $table->date('stock_date')->nullable()->after('adjust_reason');
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
            $table->dropColumn('custome_field')->nullable();
            $table->dropColumn('adjust_reason')->nullable();
            $table->dropColumn('stock_date')->nullable();
         });
    }
}
