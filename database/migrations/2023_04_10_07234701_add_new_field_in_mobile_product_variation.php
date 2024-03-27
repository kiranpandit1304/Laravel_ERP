<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldInMobileProductVariation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('product_variation', function (Blueprint $table) {
            $table->string('tax_included')->nullable()->after('tax_rate');
            $table->date('asofDate')->nullable()->after('tax_included');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('product_variation', function (Blueprint $table) {
            $table->dropColumn('tax_included');
            $table->dropColumn('asofDate');
        });
    }
}
