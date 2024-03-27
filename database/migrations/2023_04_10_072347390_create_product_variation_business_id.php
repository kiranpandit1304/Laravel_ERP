<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createproductvariationbusinessid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variation', function (Blueprint $table) {
            $table->integer('business_id')->default(0)->after('id');
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
            $table->dropColumn('business_id')->nullable();
         });
    }
}
