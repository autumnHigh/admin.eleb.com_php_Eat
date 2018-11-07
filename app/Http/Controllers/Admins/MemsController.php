<?php

namespace App\Http\Controllers\Admins;

use App\Models\Mems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemsController extends Controller
{
    //显示会员列表到index列表中
    public function index(Request $request){

        //dump($request->username);
        $wheres=[];
        if($request->username){
            $wheres[]=['username','like',"%{$request->username}%"];
/*
            $mems=Mems::where($wheres)->Paginate(1);
            //dump($mem);
            return view('mems.index',compact('mems'));*/
        }

        $mems=Mems::where($wheres)->Paginate(1);
        //dump($mems);
        return view('mems.index',compact('mems'));
    }

    //修改会员使用状态值从0 ==》》1
    public function edit($mems){
        //dd($mems);
        //根据传入的id得到符合的会员数据，在进行状态值互相  对换
        $mem=Mems::where('id','=',$mems)->first();
       // dd($mem->status);
        if($mem->status==0){
            $mem->update([
                'status'=>1  //变更为不能使用状态
            ]);
            return redirect()->route('mems.index')->with('success','变更状态为==>> 不能使用');
        }else{
            $mem->update([
                'status'=>0  //变更为使用状态
            ]);
            return redirect()->route('mems.index')->with('success','变更状态为=-=-》可以使用');
        }

    }


    //显示详情数据
    public function info($mems){
        //dd($mems);
        $mem=Mems::where('id','=',$mems)->first();
       // dd($mem);
        return view('mems.info',compact('mem'));
    }



}
