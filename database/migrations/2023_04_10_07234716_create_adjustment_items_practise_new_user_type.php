<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createadjustmentitemspractisenewusertype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustment_items_practise', function (Blueprint $table) {
            $table->text('user_type')->nullable()->after('vendor_id');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('adjustment_items_practise', function (Blueprint $table) {
            $table->dropColumn('user_type')->nullable();
         });
    }
}
