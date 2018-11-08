<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    //控制权限【编辑或者删除】
    public function __construct(){
        $this->middleware('auth',[
            'except'=>['index'],
        ]);
    }

    //显示添加管理员的页面
    public function create(){
        //查询roles角色表中的数据，显示在添加表单中
        $roles=Role::all();
       // dump($roles);
        return view('admin.add',compact('roles'));
    }

    //保存新增的数据
    public function store(Request $request){
        dump($_POST);

        //通过传入的角色id得到角色的对象数据存放到数组中
        $mhp=[];

        foreach($request->roles as $r){
           // dump($r);
            $mhp[]=Role::where('id','=',$r)->first();
        }
        dump($mhp);


        //$this->validate();
        DB::beginTransaction();

        try{
            $admin=Admin::create([
                'name'=>$request->name,
                'password'=>bcrypt($request->password),//加密密码
                'email'=>$request->email,
                'remember_token'=>str_random('50'),
            ]);

            //$admin->assignRole($mhp);
            $admin->syncRoles($mhp);


            return redirect()->route('admin.index')->with('success','添加成功');

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
        }

    }

    //显示管理员数据到页面上
    public function index(){
        $admins=Admin::Paginate(1);
        return view('admin.index',compact('admins'));
    }


    //编辑管理员信息
    public function edit(Admin $admin){
        //dd($admin);
        //得到全部角色数据，显示在页面中
        $roles=Role::all();
        //得到符合的角色信息，回显在页面中 进行修改操作
        //dd($admin);
        $roless=DB::table('model_has_roles')->where('model_id','=',$admin->id)->get();
//dd($roless);

        //保存查询出来的roles的数据
        $mhr=[];
        foreach($roless as $m){
            //dump($m);
            $mhr[]=Role::where('id','=',$m->role_id)->value('id');
        }
        //dd($mhr);


       return view('admin.edit',compact('admin','roles','mhr'));
    }


    //保存新增的数据到数据表admins中
    public function update(Admin $admin,Request $request){
        //dd($_POST,Auth::user()->password);

       // dd($_POST);


       // dump($mhr);
        //exit;

        if (Hash::check($request->oldpassword,Auth::user()->password)) {


            $this->validate($request,[
                'newPassword'=>'required|confirmed',
            ],[
                'newPassword.required'=>'新密码不能为空',
                'newPassword.confirmed'=>'两次密码输入不正确',
            ]);

            $admin->update([
                'name'=>$request->name,
                'password'=>bcrypt($request->newPassword),
                'email'=>$request->email,
            ]);

            //先查询出原有的角色信息
            // $roles = $admin->getRoleNames();
            // dump($roles);

            //存储角色对象，形成数组
            $mhr=[];
            foreach($request->roles as $r){
                dump($r);
                $mhr[]=Role::where('id','=',$r)->first();
            }

            //修改rbac角色
            // $user->syncRoles(['writer', 'admin']);
            $admin->syncRoles($mhr);
            // $user->assignRole($mhr);
            // dump($mhr);

            //修改密码成功后退出到登陆页面，重新登陆
            return redirect()->route('session.dess')->with('success','修改密码成功，请从新登陆');


        }else{
            return back()->with('danger','请确认信息');
        }



    }

    //删除指定的一条数据
    public function destroy(Admin $admin){
        $admin->delete();
        return redirect()->route('admin.index')->with('success','添加成功');
    }

    //错误提示界面
    public function error(){
        return view('403.index');
    }

}
