<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersStateName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('billing_country_name')->nullable();
            $table->string('billing_state_name')->nullable();
            $table->string('shipping_country_name')->nullable();
            $table->string('shipping_state_name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('billing_country_name');
            $table->dropColumn('billing_state_name');
            $table->dropColumn('shipping_country_name');
            $table->dropColumn('shipping_state_name');
        });
    }
}
