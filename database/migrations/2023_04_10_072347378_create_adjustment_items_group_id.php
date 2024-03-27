<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createadjustmentitemsgroupid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustment_items', function (Blueprint $table) {
            $table->integer('group_id')->nullable()->after('adjustment_id');
            $table->integer('is_group')->default(0)->after('group_id');
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
            $table->dropColumn('group_id')->nullable();
            $table->dropColumn('is_group')->nullable();
         });
    }
}
