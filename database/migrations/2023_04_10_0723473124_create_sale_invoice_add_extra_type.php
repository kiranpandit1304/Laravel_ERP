<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceaddextratype  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->string('final_total_discount_reductions_unit')->nullable()->after('final_total_discount_reductions');
            $table->string('extra_changes_unit')->nullable()->after('final_extra_charges');
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
            $table->dropColumn('final_total_discount_reductions_unit')->nullable();
            $table->dropColumn('extra_changes_unit')->nullable();
         });
    }
}
