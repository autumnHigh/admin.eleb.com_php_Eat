<?php

namespace App\Http\Controllers\Admins;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    //添加访问页面权限
    public function __construct(){
        $this->middleware('auth',[
            'except'=>['index'],
        ]);
    }



    //显示添加权限的表单
    public function create(){
        return view('permission.add');
    }

    //保存新增的权限到数据表permissions权限表 中
    public function store(Request $request){

        \Spatie\Permission\Models\Permission::create([
            'name'=>$request->name
        ]);
        //return ('添加权限成功');
        return redirect()->route('permission.index')->with('success','添加权限成功');

    }

    //显示所有的权限到列表中
    public function index(){
        $permissions=\Spatie\Permission\Models\Permission::Paginate(10);
       // dd($permissions);
        return view('permission.index',compact('permissions'));
    }

    //指定修改的权限数据
    public function edit(\Spatie\Permission\Models\Permission $permission){
        //dd($permission);
        return view('permission.edit',compact('permission'));
    }

    //保存修改的权限数据
    public function update(\Spatie\Permission\Models\Permission $permission,Request $request){
       //dump($permission,$request->name);
        $permission->update([
            'name'=>$request->name
        ]);
        return redirect()->route('permission.index')->with('success','修改权限成功');
    }

    //删除指定的数据
    public function destroy(\Spatie\Permission\Models\Permission $permission){
        //dd($permission);
        $permission->delete();
        return redirect()->route('permission.index')->with('success','删除权限成功');
    }

}
