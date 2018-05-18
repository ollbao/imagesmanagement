<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_id')->index()->comment('images表id');
            $table->string('scenes')->nullable()->comment('使用场景');
            $table->string('url')->nullable()->comment('线上地址');
            $table->string('description')->nullable()->comment('描述');
            $table->string('admin_name')->comment('下载用户');
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
        Schema::dropIfExists('download_histories');
    }
}
