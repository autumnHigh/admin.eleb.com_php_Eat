<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shops;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //显示添加商户信息的表单
    public function create()
    {
        return view('user.add');
    }


    //显示商家账号表的所有数据到index表单上
    public function index()
    {
        $users = User::Paginate(1);
        return view('user.index', compact('users'));
    }

    //编辑商家账户表的一条数据
    public function edit(User $user)
    {
        // dd($user);
        return view('user.edit', compact('user'));
    }

    //保存编辑修改的商户账号表的一条shuju
    public function update(User $user,Request $request)
    {
        $this->validate($request,[
           'name'=>'required',
           'email'=>'email',
           'password'=>'required',
        ],[
            'name.required'=>'账户不能为空',
            'email.email'=>'邮件。。。错误',
            'password.required'=>'密码不能为空',
        ]);

        //得到要修改的额数据,通过shop_id去修改shops商户信息表的店铺名称
        $shopInfo=Shops::where('id','=',$user->shop_id)->first();
       //dd($shopInfo);
        $shopInfo->update([
            'shop_name'=>$request->shop_name,
        ]);


        //修改商户账号数据模块
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);

        return redirect()->route('user.index')->with('success','修改成功');
    }


    //删除商号账户users和商户详细数据表shops 一一对应的数据
    public function destroy(User $user){
        //dd($user);

        $shop=Shops::where('id','=',$user->shop_id)->first();
        //dd($shop,$shop->shop_img);
        //删除指定id的所有数据信息
        $oo=Shops::where('id','=',$user->shop_id)->delete();

        //删除上传的文件【图片。。。】
        $qq=Storage::delete($shop->shop_img);
dump($qq,$oo);

        $user->delete();
        return redirect()->route('user.index')->with('success','删除成功');
    }


    //重置密码
    public function new(User $user){
        //dd($user);

        $pwd=str_random(8);
        //dd($pwd);

        //定义发送邮件的信息
        $data=['name'=>$user->name,'email'=>$user->email,'pwd'=>$pwd];
        //dd($data);

        //发送邮件模块
        $this->send($data);
//return'发送邮件成功';
        //充值密码到数据表的模块
        $user->update([
            'password'=>bcrypt($pwd)
        ]);
        return '重置密码成功';
    }


    //充值密码的时候发送邮件给用户
    public function send($data){
        Mail::send('email',['name'=>$data['name'],'pwd'=>$data['pwd']], function($message) use($data)
        {
            $message->to($data['email'])->subject('重置密码，测试one！');
        });
    }


    //禁止账号登陆
    public function warning(User $user){
        //dd($user);
        if($user->status!=0){
            $user->update([
                'status'=>0,
            ]);
            return redirect()->route('user.index')->with('success','禁用成功');
        }else{
            $user->update([
                'status'=>1,
            ]);
            return redirect()->route('user.index')->with('success','解除禁用成功');
        }

    }

}

