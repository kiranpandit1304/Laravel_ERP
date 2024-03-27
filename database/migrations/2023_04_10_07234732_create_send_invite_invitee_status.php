<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsendinviteinviteestatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('send_invite', function (Blueprint $table) {
            $table->string('invitee_status')->default('Pending')->after('permission_id');
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
            $table->dropColumn('invitee_status')->nullable();
         });
    }
}
