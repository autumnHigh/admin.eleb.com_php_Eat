<?php

namespace App\Http\Controllers\Admins;

use App\Models\EventMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventMemberController extends Controller
{
    //显示添加抽奖报名表的表单
    public function index(){
        $evembs=EventMember::Paginate(2);
        return view('eventmem.list',compact('evembs'));
    }
}
