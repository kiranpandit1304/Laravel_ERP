<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldInUsersGst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
            $table->string('gst_no')->nullable()->after('last_name');
            $table->string('pan_card')->nullable()->after('gst_no');
            $table->string('business_name')->nullable()->after('pan_card');
            $table->string('brand_name')->nullable()->after('business_name');
            $table->text('address')->nullable()->after('brand_name');
            $table->string('country_id')->nullable()->after('address');
            $table->string('state_id')->nullable()->after('country_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('gst_no');
            $table->dropColumn('pan_card');
            $table->dropColumn('business_name');
            $table->dropColumn('brand_name');
            $table->dropColumn('address');
            $table->dropColumn('country_id');
            $table->dropColumn('state_id');

        });
    }
}
