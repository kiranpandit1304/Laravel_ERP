<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createvendersdocname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venders_files', function (Blueprint $table) {
            $table->string('vendor_doc_name')->nullable()->after('vendor_id');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('venders_files', function (Blueprint $table) {
            $table->dropColumn('venders_doc_name')->nullable();
         });
    }
}
