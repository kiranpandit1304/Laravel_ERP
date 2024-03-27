<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createbusinessaddphone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->string('bussiness_gstin')->nullable()->after('zip_code');
            $table->string('bussiness_phone')->nullable()->after('bussiness_gstin');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn('bussiness_gstin')->nullable();
            $table->dropColumn('bussiness_phone')->nullable();
         });
    }
}
