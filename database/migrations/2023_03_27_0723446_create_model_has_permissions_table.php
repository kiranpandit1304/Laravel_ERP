<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_has_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->nullable();
            $table->integer('permission_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('guard_name')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_has_permissions');
    }
}
