<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->index('parent_id')->comment('父id')->default(0);
            $table->string('ename', 120)->index('ename')->nullable()->comment('标识符');
            $table->string('name')->comment('名称');
            $table->string('path_level')->nullable()->comment('层级顺序');
            $table->string('group_type', 120)->nullable()->index('group_type')->comment('类型');
            $table->string('thumb')->nullable()->comment('图片');
            $table->string('icon')->nullable()->comment('图标');
            $table->string('banner')->nullable()->comment('banner图片');
            $table->smallInteger('pagesize')->commnet('列表显示数量')->nullable();
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('is_checked')->default(1)->comment('状态1:启用,0:禁用');
            $table->string('seo_title', 200)->nullable()->comment('SEO标题');
            $table->string('seo_key', 255)->nullable()->comment('SEO关键词');
            $table->string('seo_desc', 255)->nullable()->comment('SEO描述');

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
        Schema::dropIfExists('categories');
    }
}
