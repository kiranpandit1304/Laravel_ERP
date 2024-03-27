<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldInWarehouses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->integer('country')->nullable()->after('address');
            $table->integer('state')->nullable()->after('country');
            $table->string('email')->nullable()->after('city_zip');
            $table->string('latitude')->nullable()->after('email');
            $table->string('longitude')->nullable()->after('latitude');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('state');
            $table->dropColumn('email');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');

        });
    }
}
