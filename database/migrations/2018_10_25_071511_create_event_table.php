<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique()->comment('抽奖活动名称');
            $table->text('content')->comment('抽奖活动详情');
            $table->string('signup_start')->comment('报名开始时间');
            $table->string('signup_end')->comment('报名结束时间');
            $table->string('prize_date')->comment('开奖日期');
            $table->integer('signup_num')->comment('报名人数限制');
            $table->tinyInteger('is_prize')->comment('是否已开奖');
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
        Schema::dropIfExists('event');
    }
}
