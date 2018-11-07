<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    //显示抽奖活动表单
    public function create(){
        return view('event.add');
    }

    //保存新增的抽奖活动信息
    public function store(Request $request){
//        dd($_POST,$request->signup_end);


        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'signup_start' => 'required',
            'signup_end' => 'required',
            'prize_date' => 'required',
            'signup_num' => 'required',
        ],[
            'title.required'=>'活动试用不能为空',
            'signup_start.required'=>'活动开始时间不能为空',
            'signup_end.required'=>'活动开始时间不能为空',
            'prize_date.required'=>'活动结束时间不能为空',
            'signup_num.required'=>'活动开奖时间不能为空',
        ]);

        if ($validator->fails()) {
            return redirect('event/create')
                ->withErrors($validator)
                ->withInput();
        }


       Event::create([
            'title'=>$request->title,
            'content'=>$request->content,
            'signup_start'=>$request->signup_start,
            'signup_end'=>$request->signup_end,
            'prize_date'=>$request->prize_date,
            'signup_num'=>$request->signup_num,
        ]);

        return redirect()->route('event.index')->with('success','添加试用活动成功');
       // return '添加抽奖活动成功';
    }


    //显示所有的活动到列表上
    public function index(){
        $events=Event::Paginate(5);
       // dd($events);
        return view('event.index',compact('events'));
    }


    //编辑状态模块
    public function edit(Event $event){
        //dd($event);
        return view('event.edit',compact('event'));
    }

    //保存修改的数据
    public function update(Event $event,Request $request){
        //dd($_POST);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'signup_start' => 'required',
            'signup_end' => 'required',
            'prize_date' => 'required',
            'signup_num' => 'required',
        ],[
            'title.required'=>'活动试用不能为空',
            'signup_start.required'=>'活动开始时间不能为空',
            'signup_end.required'=>'活动开始时间不能为空',
            'prize_date.required'=>'活动结束时间不能为空',
            'signup_num.required'=>'活动开奖时间不能为空',
        ]);

        if ($validator->fails()) {
            return redirect('event/create')
                ->withErrors($validator)
                ->withInput();
        }


        $event->update([
            'title'=>$request->title,
            'content'=>$request->content,
            'signup_start'=>$request->signup_start,
            'signup_end'=>$request->signup_end,
            'prize_date'=>$request->prize_date,
            'signup_num'=>$request->signup_num,
        ]);
       // return '修改抽奖活动成功';
        return redirect()->route('event.index')->with('success','修改试用活动成功');
    }

    //删除指定的一条数据
    public function destroy(Event $event){
        dd($event);
        //根据传入的抽奖活动的id得到 报名表是否有人，报名，如果有人报名 并且还没有过期，开奖，就不能删
        //$event->delete();


    }
}
