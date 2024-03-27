<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendersPlatform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venders', function (Blueprint $table) {
            $table->string('platform')->nullable()->after('vender_id');
            $table->string('guard')->nullable()->after('platform');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('venders', function (Blueprint $table) {
            $table->dropColumn('platform');
            $table->dropColumn('guard');
        });
    }
}