<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableActive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建品台活动表
        Schema::create('actives', function (Blueprint $table) {
            $table->increments('id')->comment('主键id');
            $table->string('title')->comment('活动名称');
            $table->text('content')->comment('活动详情');
            $table->string('start_time')->comment('活动开始时间');
            $table->string('end_time')->comment('活动结束时间');
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
        //
    }
}
