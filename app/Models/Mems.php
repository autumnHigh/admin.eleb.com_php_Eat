<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mems extends Model
{
    //定义要操作的数据表
    protected $table='members';
    //定义要操作的属性字段
    protected $fillable=['status'];//只修改一个状态字段
}
