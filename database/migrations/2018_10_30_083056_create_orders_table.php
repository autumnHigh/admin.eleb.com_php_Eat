<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->comment('订单表主键id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('shop_id')->comment('商家id');
            $table->string('sn')->comment('订单编号');
            $table->string('province')->comment('收货省地址');
            $table->string('city')->comment('收货市地址');
            $table->string('county')->comment('收货县地址');
            $table->string('address')->comment('详细地址');
            $table->string('tel')->comment('收货人电话');
            $table->string('name')->comment('收货人姓名');
            $table->decimal('total')->comment('价格金额');
            $table->tinyInteger('status')->comment('状态(-1:已取消,0:待支付,1:待发货,2:待确认,3:完成)');
            $table->string('out_trade_no')->comment('第三方交易号(微信支付需要)');
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
        Schema::dropIfExists('orders');
    }
}
