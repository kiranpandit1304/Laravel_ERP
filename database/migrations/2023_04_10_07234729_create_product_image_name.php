<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createproductimagename extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_image', function (Blueprint $table) {
            $table->string('product_image_name')->nullable()->after('product_id');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('product_image', function (Blueprint $table) {
            $table->dropColumn('product_image_name')->nullable();
         });
    }
}
