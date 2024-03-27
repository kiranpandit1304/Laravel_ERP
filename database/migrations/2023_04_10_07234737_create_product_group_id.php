<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createproductgroupid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_services', function (Blueprint $table) {
            //$table->integer('group_id')->nullable()->after('name');
            $table->integer('group_stock')->nullable()->after('name');
            $table->integer('is_group')->default(0)->after('group_stock');
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
            $table->dropColumn('group_id')->nullable();
            $table->dropColumn('group_stock')->nullable();
            $table->dropColumn('is_group')->nullable();
         });
    }
}
