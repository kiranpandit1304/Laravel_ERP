<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createproductvariationplatform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variation', function (Blueprint $table) {
            $table->text('platform')->nullable()->after('variation_name');
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
        
        Schema::table('product_variation', function (Blueprint $table) {
            $table->dropColumn('platform')->nullable();
            $table->dropColumn('guard')->nullable();
         });
    }
}
