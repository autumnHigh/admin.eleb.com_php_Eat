<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //定义要操作的表
    protected $table='events';
    //定义要操作的属性字段
    protected $fillable=['title','content','signup_start','signup_end','prize_date','signup_num','is_prize'];
}
