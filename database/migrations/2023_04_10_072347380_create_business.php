<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createbusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->nullable();
            $table->string('guard')->nullable();
            $table->string('business_logo')->nullable();
            $table->string('business_logo_name')->nullable();
            $table->string('email')->nullable();
            $table->integer('is_gst')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('business_name')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('street_address')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('pan_no')->nullable();
            $table->integer('team_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
         Schema::dropIfExists('business');
    }
}
