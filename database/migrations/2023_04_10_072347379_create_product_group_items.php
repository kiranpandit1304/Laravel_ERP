<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createproductgroupitems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('product_group_items', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('variation_id')->nullable();
            $table->integer('bundle_quantity')->nullable();
            $table->string('total_cost_price')->nullable();
            $table->integer('total_selling_price')->nullable();
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
        
         Schema::dropIfExists('product_group_items');
    }
}
