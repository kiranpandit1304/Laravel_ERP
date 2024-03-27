<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_id')->nullable()->default('0');
            $table->integer('from_warehouse_id')->nullable();
            $table->integer('to_warehouse_id')->nullable();
            $table->date('transfer_date')->nullable();
            $table->integer('transfer_number')->nullable()->default('0');
            $table->integer('status')->nullable()->default('0');
            $table->integer('shipping_display')->nullable()->default('1');
            $table->date('send_date')->nullable()->nullable();
            $table->integer('discount_apply')->nullable()->default('0');
            $table->integer('category_id')->nullable();
            $table->text('description')->nullable();
            $table->text('discount')->nullable();
            $table->integer('created_by')->nullable()->default('0');
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
        Schema::dropIfExists('transfer');
    }
}
