<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', '64')->comment('登录用户名');
            $table->string('nickname', '64')->comment('用户昵称');
            $table->string('face')->nullable()->comment('头像');
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('is_super')->default(0)->comment('是否是超级管理员:0-不是 1-是');
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
        Schema::dropIfExists('admins');
    }
}
