<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
    //定义要操作的活动表
    protected $table='actives';
    //定义要操作的活动表的属性字段
    protected $fillable=['title','content','start_time','end_time'];
}
