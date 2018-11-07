<?php

namespace App\Http\Controllers\Admins;

use App\Models\Audit;
use App\Models\Shops;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuditController extends Controller
{

    public function __construct(){
        $this->middleware('auth',[
            'except'=>['index'],
        ]);
    }



    //显示没有被审核的数据 shops表中的status == 0 的数据
    public function index(){
       // $audits=Shops::where('status','=','0')->Paginate(1);
       // $audits=DB::table('shops')->join('users','shops.id','=','users.shop_id')->select('users.*','shops.status as shopStatus','shops.shop_name')->get();

        $audits=Shops::where('status','=','0')->get();


        //dd($audits);
        return view('audit.index',compact('audits'));
    }

    //保存审核后的商品信息到指定的数据条中
    public function edit(Shops $audit){
        dd($audit);
        //$audit=Shops::where('id','=',$audit)->get();
       // dd($audit);
        //审核shops商铺表中的状态值
        return view('audit.edit',compact('audit'));
    }

    //保存修改的数据
    public function update(Shops $audit){
        //dd($audit->shop_name);
        //根据传入的商家信息得到商户的信息
        $user=\App\Models\User::where('shop_id','=',$audit->id)->first();
//dd($user);


        //当 点击  审核通过的时候，修改shops表中的商户的状态值 status ==> 1
        $audit->update([
            'status'=>1,
        ]);

        //当点击审核时发送邮件到商家邮箱中
        $data=['name'=>$user->name,'email'=>$user->email,'shop_name'=>$audit->shop_name];
//dd($data);

        //发送邮件模块
        $this->send($data);
        //dump('发送成功');

        return redirect()->route('audit.index')->with('success','审核通过');
    }

    //发送邮件函数
    public function send($data){
        Mail::send('email_shop', ['name'=>$data['name'],'shop_name'=>$data['shop_name']], function($message) use($data)
        {
            $message->to($data['email'])->subject('商家店铺激活成功！！！');
        });
    }


    //删除审核状态数据
    public function destroy(Shops $audit){
       // dd($audit->id);
        $img=Shops::where('id','=',$audit->id)->first();
        //dd($img->shop_img);

        //删除指定的审核数据
        $audit->delete();
        //删除审核的图片
        Storage::delete($img->shop_img);

        return redirect()->route('audit.index')->with('success','删除成功');

    }

}
