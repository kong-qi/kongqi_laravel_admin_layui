<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id')->default(0)->comment('所属分组id');
            $table->string('tmp_name', 255)->default('')->comment('原始名字');
            $table->string('type', 60)->default('image')->comment('文件类型:image,vedio,pdf,office,zip,rar,other');
            $table->string('filename', 255)->comment('新文件名');
            $table->integer('size')->default(0)->comment('文件大小');
            $table->string('path', 255)->comment('文件路径');
            $table->string('origin_path', 255)->comment('不含域名文件路径');
            $table->string('oss_type', 60)->default('local')->comment('存储位置');
            $table->string('user_type', 60)->comment('上传用户类型:');
            $table->integer('user_id')->unsigned()->comment('所属用户id');
            $table->string('ext', 30)->nullable()->comment('后缀名');
            $table->index(['user_type', 'user_id']);
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
        Schema::dropIfExists('files');
    }
}
