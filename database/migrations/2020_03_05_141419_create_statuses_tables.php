<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTables extends Migration
{
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->integer('user_id')->index();
            $table->index(['created_at']);
            //为created_at创建索引，timestamps会会为微博数据表生成一个微博创建时间字段 created_at 和一个微博更新时间字段 updated_at。为微博的创建时间添加索引的目的是，后面我们会根据微博的创建时间进行倒序输出，并在页面上进行显示，使新建的微博能够排在比较靠前的位置。
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
        Schema::dropIfExists('statuses');
    }
}
