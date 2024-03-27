<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createadjustmentitemspractiseplatform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustment_items_practise', function (Blueprint $table) {
            $table->text('platform')->nullable()->after('product_id');
            $table->text('guard')->nullable()->after('platform');
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
            $table->dropColumn('platform')->nullable();
            $table->dropColumn('guard')->nullable();
         });
    }
}
