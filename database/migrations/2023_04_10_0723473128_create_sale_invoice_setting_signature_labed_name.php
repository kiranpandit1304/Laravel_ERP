<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoicesettingsignaturelabedname  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice_setting', function (Blueprint $table) {
            $table->string('s3_signature_url')->nullable()->after('signature_url');
            $table->string('signature_labed_name')->nullable()->after('signature_name');
            $table->string('due_days')->nullable()->after('business_id');
            $table->string('is_bank_detail_show_onInv')->default(0)->after('signature_labed_name');
            $table->string('is_upi_detail_show_onInv')->default(0)->after('is_bank_detail_show_onInv');
            $table->string('last_active_bank_id')->default(0)->after('is_upi_detail_show_onInv');
            $table->string('last_active_upi_id')->default(0)->after('last_active_bank_id');
        
           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('sale_invoice_setting', function (Blueprint $table) {
            $table->dropColumn('s3_signature_url')->nullable();
            $table->dropColumn('signature_labed_name')->nullable();
            $table->dropColumn('due_days')->nullable();
            $table->dropColumn('is_bank_detail_show_onInv')->nullable();
            $table->dropColumn('is_upi_detail_show_onInv')->nullable();
            $table->dropColumn('last_active_bank_id')->nullable();
            $table->dropColumn('last_active_upi_id')->nullable();
         });
    }
}
