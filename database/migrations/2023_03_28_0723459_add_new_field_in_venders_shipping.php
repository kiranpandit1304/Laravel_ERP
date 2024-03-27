<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldInVendersShipping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('venders', function (Blueprint $table) {
            $table->string('nature_of_business')->nullable()->after('email_verified_at');
            $table->string('contact_person')->nullable()->after('nature_of_business');
            $table->string('bussiness_gstin')->nullable()->after('contact_person');
            $table->string('pan')->nullable()->after('bussiness_gstin');
            $table->string('is_msme')->nullable()->after('pan');
            
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
            $table->dropColumn('nature_of_business');
            $table->dropColumn('contact_person');
            $table->dropColumn('bussiness_gstin');
            $table->dropColumn('pan');
            $table->dropColumn('is_msme');

        });
    }
}