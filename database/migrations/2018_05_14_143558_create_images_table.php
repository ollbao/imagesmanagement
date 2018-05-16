<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag')->index()->comment('图片标签');
            $table->string('show_url')->comment('图片展示链接');
            $table->string('down_path')->comment('图片下载路径');
            $table->string('image_source')->default('')->comment('图片来源');
            $table->string('source_link')->default('')->comment('图片原始链接');
            $table->string('description')->nullable()->comment('图片描述');
            $table->integer('admin_id')->unsigned()->comment('上传用户id');
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
        Schema::dropIfExists('images');
    }
}
