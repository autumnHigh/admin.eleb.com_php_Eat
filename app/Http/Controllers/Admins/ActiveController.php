<?php

namespace App\Http\Controllers\Admins;

use App\Models\Active;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActiveController extends Controller
{
    //显示添加活动的表单
    public function create(){
        return view('active.add');
    }

    //保存新添加的活动的数据
    public function store(Request $request){
        //dd($_POST);
        Active::create([
            'title'=>$request->title,
            'content'=>$request->content,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
        ]);
        return '添加活动成功';
    }

    //显示所有的互动的数据
    public function index(){

        //接受get方式传送的值
        $data=$_GET['id']??'0';
        //dump($_GET);
        //当前日日期时间
        $start=date('Y-m-d',time());

        dump($start);

        if($data==1){//这是未开始的活动
            dump($data);
            $actives=Active::where('start_time','>=',$start)->Paginate(1);
            return view('active.index',compact('actives','data'));

        }elseif($data==2){//这是【活动中】的活动
            dump($data);
            $actives=Active::where('start_time','<=',$start)->where('end_time','>=',$start)->Paginate(1);
            return view('active.index',compact('actives','data'));

        }elseif($data==3){//这是已结束的活动
            dump($data);
            $actives=Active::where('end_time','<=',$start)->Paginate(1);
            return view('active.index',compact('actives','data'));
        }

        $actives=Active::Paginate(1);
        return view('active.index',compact('actives','data'));
    }

    //对于指定的活动的修改
    public function edit(Active $active){
        //dd($active);
        return view('active.edit',compact('active'));
    }

    //保存修改后的数据到数据表中
    public function update(Active $active,Request $request){
       //dd($request->content,$request->start_time,$request->end_time);
        $active->update([
            'title'=>$request->title,
            'content'=>$request->content,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
        ]);
        return '修改活动成功';
    }
}
