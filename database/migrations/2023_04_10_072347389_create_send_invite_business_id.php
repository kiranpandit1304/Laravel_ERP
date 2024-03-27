<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsendinvitebusinessid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('send_invite', function (Blueprint $table) {
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
        
        Schema::table('send_invite', function (Blueprint $table) {
            $table->dropColumn('business_id')->nullable();
         });
    }
}
