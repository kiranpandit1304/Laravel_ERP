<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createproductvariationaddproductid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variation', function (Blueprint $table) {
            $table->integer('product_id')->nullable()->after('id');
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
            $table->dropColumn('product_id')->nullable();
         });
    }
}
