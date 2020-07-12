<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('插件名称');
            $table->string('thumb')->comment('插件缩略图')->nullable();
            $table->string('ename')->index('ename')->comment('插件标识符');
            $table->string('version')->comment('版本号');
            $table->string('author')->nullable()->comment('插件作者');
            $table->string('intro')->nullable()->comment('插件简介');
            $table->text('plugin_data')->nullable()->comment('相关数据');
            $table->boolean('is_install')->comment('是否安装')->default(0);
            $table->boolean('is_menu')->comment('是否安装菜单')->default(0);
            $table->boolean('is_checked')->comment('是否启用')->default(1);
            $table->string('source')->comment('插件来源')->default('local');
            $table->tinyInteger('menu_show')->comment('显示位置:0插件入库进入，1菜单进入')->default(1);
            $table->integer('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('plugins');
    }
}
