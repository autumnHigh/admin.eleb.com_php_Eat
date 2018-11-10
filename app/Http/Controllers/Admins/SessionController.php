<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SessionController extends Controller
{

    //限制游客访问的参数
    public function __construct(){
        $this->middleware('guest',[
            'only'=>['create','store'],
        ]);
    }

    //显示登陆页面
    public function create(){
        return view('session.add');
    }

    //验证登陆
    public function store(Request $request){

        $this->validate($request,[
            'name'=>'required|between:2,6',
            'password'=>'required|between:2,8',
           // 'captcha'=>'required|captcha',
        ],[
            'name.required'=>'用户民不能为空',
            'name.between'=>'用户名位数不对',
           'password.required'=>'密码不能为空',
           'password.between'=>'用户密码位数不对',
            //'captcha.required'=>'验证码不能为空',
            //'captcha.captcha'=>'验证码错误',
       ]);


      //  $this->validate($request,[
       //     'name'=>'required',
       //     'password'=>'required',
     //   ]);*/

        if(Auth::attempt(['name'=>$request->name,'password'=>$request->password],$request->has('remember'))){
          //return '登陆成功';
            //return redirect()->intended(route('admin.index'))->with('success',$request->name.'登陆成功');
            return redirect()->route('admin.index')->with('success',$request->name.'登陆成功');
        }else{
           // return '登陆失败';
            return back()->with('danger',$request->name.'登陆失败')->withInput();
        }
    }


    //编辑自动调换登陆页面
    public function login(){
        return view('session.add');
   }


    //推出登陆
    public function dess(){
        Auth::logout();
        return redirect()->route('session.create')->with('success','退出成功');
    }

}
