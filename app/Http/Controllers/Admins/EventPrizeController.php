<?php

namespace App\Http\Controllers\Admins;

use App\Models\Event;
use App\Models\EventMember;
use App\Models\EventPrize;
//use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EventPrizeController extends Controller
{
    //显示奖品表单
    public function create(){
        //查询 试用活动。。
        $time=date('Y-m-d',time());
       // dump($time);
        $events=Event::where([['prize_date','>=',$time],['is_prize','=','0']])->get();
//dd($events);
        return view('eventprize.add',compact('events'));
    }

    //保存新增的数据
    public function store(Request $request){
        dump($_POST);

        //dd($request->events_id);
        //根据传入的id得到符合的一条数据,抽奖前可以添加
        $events=Event::where('id','=',$request->events_id)->first();
       // dd($events);
        //获得要添加的奖品的当前时间
        //$newDate=date('Y-m-d',time());

        if(date('Y-m-d',time()) < $events->prize_date){
            EventPrize::create([
                'events_id'=>$request->events_id,
                'name'=>$request->name,
                'description'=>$request->description,
            ]);
            return '添加奖品成功';
        }else{
            return '活动开奖时间到了，别想添加了';
        }

    }

    //显示指定的数据
    public function index(){
        //$eveps=EventPrize::all();
        $eveps=EventPrize::Paginate(5);
        return view('eventprize.index',compact('eveps'));
    }

    //在开奖之前可以修改奖品数据
    public function edit(EventPrize $evp){
       // dump($evp);
        //得到试用活动表的符合奖品的数据
       // $event=Event::where('id','=',$evp->events_id)->first();
//dd($event);

        return view('eventprize.edit',compact('evp'));
    }

    //保存修改的抽奖活动名单
    public function update(EventPrize $evp,Request $request){
        //dump($evp,$_POST);

        //dd($evp->getEvent->prize_date);
      /*  //查询出奖品对应的使用活动的信息
        $event=Event::where('id','=',$evp->events_id)->first();
        dd($event);
        //得到当前的时间
        $newDate=date('Y-m-d',time());
        dump($newDate);*/

        //如果
        if(date('Y-m-d',time()) < $evp->getEvent->prize_date){
            $evp->update([
                //'events_id'=>$request->events_id,
                'name'=>$request->name,
                'description'=>$request->description,
            ]);
            return '更新奖品成功';
        }else{
            return '开奖时间已到，不能更改';
        }

    }


    //删除指定的活动奖品
    public function destroy(EventPrize $evp){
        //dd($evp);

        //dd($evp->getEvent->prize_date);

        if(date('Y-m-d',time()) < $evp->getEvent->prize_date){
            $evp->delete();
            //return '删除成功';
            return redirect()->route('evps.index')->with('success','删除成功');
        }else{
            //return '活动已经开奖或结束，不能删除';
            return redirect()->route('evps.index')->with('danger','已经开奖,不能删除');
        }

    }

    //点击开奖按钮，运行的程序
    public function lottery($evps,Request $request){
      // dump($evps);
       // $a=['1','23','2','16'];
       // dump($a);
       /* $b=array_rand($a);
        dd($a[$b]);*/
/*
        shuffle($a);
       dd(array_shift($a));*/

        //通过传入的id,得到抽奖活动的id
        $evemps=EventPrize::where('id','=',$evps)->value('events_id');
       // dump($evemps);
        //通过抽奖活动的id可以获得抽奖名单的人远
        $evmember=EventMember::where('events_id','=',$evemps)->pluck('member_id');
        //拿出来的是一个对象

        $zero=[];
        foreach($evmember as $evem){
            //dump($evem);
            $zero[]=$evem;
        }
       // dump($zero);
        //打乱数组
        shuffle($zero);
        //输出数组第一个元素，得到随机得到的中间人员【中奖人员】
        $rand=array_shift($zero);
        //dd($rand);
        //根据id得到对应的用户数据
        $user=User::where('id','=',$rand)->first();
        //dd($user);

        //通过传入的活动id得到抽奖报名表的对应数据、
        $event=EventMember::where('member_id','=',$user->id)->first();
        //dd($event->events_id);


        //通过上面得到的活动id得到活动表的id符合的数据
        $evnt=Event::where('id','=',$event->events_id)->first();
        //dd($evnt);

        //判断活动表events中的is_prize的值是否为0，如果为0就开奖，如果为1就已经开奖了，不能再次开奖
        if($evnt->is_prize==0){
            //往抽奖奖品名单 event_prizes插入中间人员id
            //===》》使用活动报名表的event->events->id得到奖品名单的奖品数据
            $evesps=EventPrize::where('events_id','=',$event->events_id)->first();
            //dd($evesps);

            $evesps->update([
                'member_id'=>$rand,
            ]);


            //修改开奖状态为开奖

            $evnt->update([
                'is_prize'=>1,
            ]);


            //定义邮件参数
            $data=['name'=>$user->name,'email'=>$user->email];
            //dd($data);
            //发送邮件到中间用户
            $this->send($data);

        return '成功开奖';

        }else{
            return '奖品已经开奖';
        }


    }


    //在添加用户的时候发送填写邮箱的邮件
    public function send($data){

        Mail::send('emails',['name'=>$data['name']], function($message) use($data)
        {
            $message->to($data['email'])->subject('中奖了，跟你一个没用的手机！');
        });

    }

    //添加活动奖品
    public function add(Event $event){
       //dump($event);

       //显示活动的信息，再添加根据活动，添加奖品信息
        return view('eventprize.addprize',compact('event'));

    }



}
