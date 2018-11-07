<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shops;
class User extends Model
{
    //定义要操作的表
    protected $table='users';
    //定义要操作的数据字段
    protected $fillable=['name','email','password','status','remember_token','shop_id'];

    //定义一对一的商家账号表和商家信息表 users => shop_id ==>> shops => id
    public function getInfo(){
        return $this->belongsTo(Shops::class,'shop_id','id');
    }

}
