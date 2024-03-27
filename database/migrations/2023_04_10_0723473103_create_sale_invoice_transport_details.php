<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicetransportdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->string('transport_challan')->nullable()->after('shipped_to_custome_filed');
            $table->string('transport_challan_date')->nullable()->after('transport_challan');
            $table->string('transport_name')->nullable()->after('transport_challan_date');
            $table->text('transport_information')->nullable()->after('transport_name');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->dropColumn('transport_challan')->nullable();
            $table->dropColumn('transport_challan_date')->nullable();
            $table->dropColumn('transport_name')->nullable();
            $table->dropColumn('transport_information')->nullable();
         });
    }
}
