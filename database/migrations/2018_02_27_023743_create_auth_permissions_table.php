<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', '25')->comment('名称');
            $table->string('route')->unique()->comment('路由');
            $table->smallInteger('status')->default(0)->comment('状态');
            $table->uuid('menu_id')->comment('隶属菜单');
            $table->string('description')->nullable()->comment('描述');
            $table->timestamps();
            $table->foreign('menu_id')->references('id')->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_permissions');
    }
}
