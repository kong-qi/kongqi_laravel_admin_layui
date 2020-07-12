<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->comment('分类id')->default(0);
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('is_checked')->default(1)->comment('状态1:启用,0:禁用');
            $table->string('name')->comment('文章标题');
            $table->string('name_color')->comment('标题颜色');
            $table->timestamp('push_at')->nullable()->comment('上架时间');
            $table->date('end_at')->nullable()->comment('隐藏时间');
            $table->string('author')->comment('作者')->nullable();
            $table->string('thumb')->comment('缩略图')->nullable();
            $table->text('thumbs')->comment('相册')->nullable();
            $table->text('content')->comment('文章内容');
            $table->string('code')->nullable()->comment('代码区域');
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
        Schema::dropIfExists('articles');
    }
}
