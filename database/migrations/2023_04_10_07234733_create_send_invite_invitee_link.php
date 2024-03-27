<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsendinviteinviteelink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('send_invite', function (Blueprint $table) {
            $table->text('link')->nullable()->after('invitee_status');
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
            $table->dropColumn('link')->nullable();
         });
    }
}
