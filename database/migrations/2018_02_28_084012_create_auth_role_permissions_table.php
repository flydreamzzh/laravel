<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_role_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('role_id');
            $table->integer('permission_id', false, true);
            $table->unique(['role_id', 'permission_id']);
            $table->foreign('role_id')->references('id')->on('auth_roles');
            $table->foreign('permission_id')->references('id')->on('auth_permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_role_permissions');
    }
}
