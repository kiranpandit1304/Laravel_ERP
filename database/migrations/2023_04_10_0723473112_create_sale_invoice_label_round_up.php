<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicelabelroundup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice_label_change', function (Blueprint $table) {
            $table->string('label_round_up')->nullable()->after('label_invoice_transport');
            $table->string('label_round_down')->nullable()->after('label_round_up');
            $table->string('label_total')->nullable()->after('label_round_down');
            $table->string('additional_info_label')->nullable()->after('label_invoice_attachments');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('sale_invoice_label_change', function (Blueprint $table) {
            $table->dropColumn('label_round_up')->nullable();
            $table->dropColumn('label_round_down')->nullable();
            $table->dropColumn('label_total')->nullable();
            $table->dropColumn('additional_info_label')->nullable();
         });
    }
}
