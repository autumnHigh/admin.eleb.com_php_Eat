<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('商户名');
            $table->string('email')->comment('邮件');
            $table->string('password')->comment('密码');
            $table->tinyInteger('status')->comment('商家状态1启用0禁用');
            $table->string('remember_token');
            $table->integer('shop_id')->comment('商家信息标的id');
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
        Schema::dropIfExists('users');
    }
}
