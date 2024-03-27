<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceaddbilling  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->string('billing_from_country_id')->nullable()->after('shipped_to_state_name');
            $table->string('billing_from_country_name')->nullable()->after('billing_from_country_id');
            $table->string('billing_from_address')->nullable()->after('billing_from_country_name');
            $table->string('billing_from_city')->nullable()->after('billing_from_address');
            $table->string('billing_from_zip_code')->nullable()->after('billing_from_city');
            $table->string('billing_from_state_name')->nullable()->after('billing_from_zip_code');

            $table->string('billing_to_country_id')->nullable()->after('billing_from_state_name');
            $table->string('billing_to_country_name')->nullable()->after('billing_to_country_id');
            $table->string('billing_to_address')->nullable()->after('billing_to_country_name');
            $table->string('billing_to_city')->nullable()->after('billing_to_address');
            $table->string('billing_to_zip_code')->nullable()->after('billing_to_city');
            $table->string('billing_to_state_name')->nullable()->after('billing_to_zip_code');


            $table->string('is_terms_req')->default(0)->after('color');
            $table->string('is_additional_notes_req')->default(0)->after('is_terms_req');
            $table->string('is_attactments_req')->default(0)->after('is_additional_notes_req');
            $table->string('is_additional_info_req')->default(0)->after('is_attactments_req');
            $table->string('template_id')->default(0)->after('is_additional_info_req');
            $table->string('is_delete')->default(0)->after('created_by');
            $table->string('payment_status')->default(Unpaid)->after('is_delete');
            






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
            $table->dropColumn('billing_from_country_id')->nullable();
            $table->dropColumn('billing_from_country_name')->nullable();
            $table->dropColumn('billing_from_address')->nullable();
            $table->dropColumn('billing_from_city')->nullable();
            $table->dropColumn('billing_from_zip_code')->nullable();
            $table->dropColumn('billingt_from_state_name')->nullable();

            $table->dropColumn('billing_to_country_id')->nullable();
            $table->dropColumn('billing_to_country_name')->nullable();
            $table->dropColumn('billing_to_address')->nullable();
            $table->dropColumn('billing_to_city')->nullable();
            $table->dropColumn('billing_to_zip_code')->nullable();
            $table->dropColumn('billingt_to_state_name')->nullable();

            $table->dropColumn('is_terms_req')->nullable();
            $table->dropColumn('is_additional_notes_req')->nullable();
            $table->dropColumn('is_attactments_req')->nullable();
            $table->dropColumn('is_additional_info_req')->nullable();
         });
    }
}
