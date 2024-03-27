<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createcustomerdocname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_files', function (Blueprint $table) {
            $table->string('customer_doc_name')->nullable()->after('client_id');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('customer_files', function (Blueprint $table) {
            $table->dropColumn('customer_doc_name')->nullable();
         });
    }
}
