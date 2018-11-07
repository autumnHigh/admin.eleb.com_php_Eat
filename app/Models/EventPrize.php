<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPrize extends Model
{
    //定义要操作的表
    protected $table='event_prizes';
    //定义要操作的属性字段
    protected $fillable=['events_id','name','description','member_id'];

    //获得活动表events的名称
    public function getEvent(){
        return $this->belongsTo(Event::class,'events_id','id');
    }
}
