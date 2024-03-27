<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createproductservicesbusinessid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_services', function (Blueprint $table) {
            $table->integer('business_id')->default(0)->after('guard');
            $table->integer('warehouse_id')->default(0)->after('business_id');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('product_services', function (Blueprint $table) {
            $table->dropColumn('business_id')->nullable();
            $table->dropColumn('warehouse_id')->nullable();
         });
    }
}
