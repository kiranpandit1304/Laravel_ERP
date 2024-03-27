<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->nullable();
            $table->string('guard')->nullable();
            $table->string('name')->nullable();
            $table->string('price')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('text_include')->nullable();
            $table->string('sac_code')->nullable();
            $table->string('gst_text')->nullable();
            $table->string('service_image_name')->nullable();
            $table->string('service_image')->nullable();
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
        
         Schema::dropIfExists('stock_history_practise');
    }
}
