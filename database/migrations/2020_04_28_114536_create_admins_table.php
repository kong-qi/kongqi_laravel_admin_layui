<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('nickname', 50)->nullable()->comment('昵称');
            $table->string('account', 120)->unique()->comment('账号');
            $table->string('password', 120)->nullable()->comment('密码');
            $table->string('session_token')->nullable()->comment('登录session_token');
            $table->boolean('is_checked')->default(1)->comment('启用1，禁用0');
            $table->boolean('is_root')->default(0)->comment('是否超级管理员');
            $table->ipAddress('last_ip')->nullable()->comment('最后一次登录IP');
            $table->integer('login_numbers')->default(0)->comment('登录次数');
            $table->rememberToken();
            $table->softDeletes();
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
