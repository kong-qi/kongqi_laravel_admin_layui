<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->index()->unsigned()->comment('所属管理员id');
            $table->string('admin_name')->comment('所属管理员');
            $table->text('name')->comment('描述');
            $table->string('type')->default('log')->comment('操作类型');
            $table->string('ip', 30)->comment('IP地址');
            $table->string('url', 150)->comment('操作地址');
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
        Schema::dropIfExists('admin_logs');
    }
}
