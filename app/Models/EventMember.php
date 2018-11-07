<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMember extends Model
{
    //定义要操作的表
    protected $table='event_members';
    //定义要操作的属性字段
    protected $fillable=['event_id','member_id'];

    //抽奖活动的数据
    public function getEvent(){
        return $this->belongsTo(Event::class,'events_id','id');
    }

    //抽奖奖品的数据
    public function getEventPrize(){
        return $this->belongsTo(User::class,'member_id','id');
    }
}
