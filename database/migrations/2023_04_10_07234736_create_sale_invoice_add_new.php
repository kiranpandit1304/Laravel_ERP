<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsaleinvoiceaddnew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_invoice', function (Blueprint $table) {
            $table->string('dicount_type')->nullable()->after('note');
            $table->string('dicount')->nullable()->after('dicount_type');
            $table->integer('b_state_id')->nullable()->after('dicount');
            $table->string('b_state_name')->nullable()->after('b_state_id');
            $table->text('custome_field')->nullable()->after('b_state_name');
            $table->string('p_address')->nullable()->after('custome_field');
            $table->string('p_area')->nullable()->after('p_address');
            $table->string('p_pincode')->nullable()->after('p_area');
            $table->string('p_city')->nullable()->after('p_pincode');
            $table->integer('p_state_id')->nullable()->after('p_city');
            $table->string('p_state_name')->nullable()->after('p_state_id');
            $table->string('u_address')->nullable()->after('p_state_name');
            $table->string('u_area')->nullable()->after('u_address');
            $table->string('u_pincode')->nullable()->after('u_area');
            $table->string('u_city')->nullable()->after('u_pincode');
            $table->integer('u_state_id')->nullable()->after('u_city');
            $table->string('u_state_name')->nullable()->after('u_state_id');
            $table->text('terms_conditions')->nullable()->after('u_state_name');
            $table->text('bill_note')->nullable()->after('terms_conditions');
            $table->string('bill_amount')->nullable()->after('bill_note');
            $table->string('photo_1')->nullable()->after('bill_amount');
            $table->string('photo_2')->nullable()->after('photo_1');
            $table->string('photo_3')->nullable()->after('photo_2');
            $table->string('photo_4')->nullable()->after('photo_3');
            $table->text('additional_charges')->nullable()->after('photo_4');
            $table->text('invice_pdf')->nullable()->after('additional_charges');

            $table->text('invice_pdf_name')->nullable()->after('invice_pdf');
            $table->text('photo_1_name')->nullable()->after('invice_pdf_name');
            $table->text('photo_2_name')->nullable()->after('photo_1_name');
            $table->text('photo_3_name')->nullable()->after('photo_2_name');
            $table->text('photo_4_name')->nullable()->after('photo_3_name');

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
            $table->dropColumn('dicount_type')->nullable();
            $table->dropColumn('dicount')->nullable();
            $table->dropColumn('b_state_id')->nullable();
            $table->dropColumn('b_state_name')->nullable();
            $table->dropColumn('custome_field')->nullable();
            $table->dropColumn('p_address')->nullable();
            $table->dropColumn('p_area')->nullable();
            $table->dropColumn('p_pincode')->nullable();
            $table->dropColumn('p_city')->nullable();
            $table->dropColumn('p_state_id')->nullable();
            $table->dropColumn('p_state_name')->nullable();
            $table->dropColumn('u_address')->nullable();
            $table->dropColumn('u_area')->nullable();
            $table->dropColumn('u_pincode')->nullable();
            $table->dropColumn('u_city')->nullable();
            $table->dropColumn('u_state_id')->nullable();
            $table->dropColumn('u_state_name')->nullable();
            $table->dropColumn('terms_conditions')->nullable();
            $table->dropColumn('bill_note')->nullable();
            $table->dropColumn('bill_amount')->nullable();
            $table->dropColumn('photo_1')->nullable();
            $table->dropColumn('photo_2')->nullable();
            $table->dropColumn('photo_3')->nullable();
            $table->dropColumn('photo_4')->nullable();
            $table->dropColumn('additional_charges')->nullable();
            $table->dropColumn('invice_pdf')->nullable();

            $table->dropColumn('invice_pdf_name')->nullable();
            $table->dropColumn('photo_1_name')->nullable();
            $table->dropColumn('photo_2_name')->nullable();
            $table->dropColumn('photo_3_name')->nullable();
            $table->dropColumn('photo_4_name')->nullable();



         });
    }
}
