<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //menu
        Schema::create('menu', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name')->comment('名称');
            $table->smallInteger('type')->default(0)->comment('0表示存粹文字，1菜单');
            $table->string('description')->nullable()->comment('描述');
            $table->string('url')->comment('路由');
            $table->string('icon')->comment('图标');
            $table->integer('lft')->comment('左值');
            $table->integer('rgt')->comment('右值');
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
        //menu
        Schema::dropIfExists('menu');
    }
}
