<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_pos', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('expense_category_id')->nullable();
            $table->double('amount')->nullable();
            $table->string('reference_code')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_type')->nullable();
            $table->text('details')->nullable();
            $table->string('title')->nullable();
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
        Schema::dropIfExists('expenses_pos');
    }
}
