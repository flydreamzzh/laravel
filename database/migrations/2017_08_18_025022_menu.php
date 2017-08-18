<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Menu extends Migration
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
            $table->increments('id');
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
