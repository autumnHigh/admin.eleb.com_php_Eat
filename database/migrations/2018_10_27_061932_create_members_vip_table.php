<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersVipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id')->comment('会员表主键id');
            $table->string('username')->unique()->comment('会员名');
            $table->string('password')->comment('会员密码');
            $table->string('tel')->comment('电话号码');
            $table->string('rememberToken')->comment('记住token=》自动登陆？');
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
        Schema::dropIfExists('members_vip');
    }
}
