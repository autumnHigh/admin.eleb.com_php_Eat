<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //显示添加role权限人员表单
    public function create(){
        $permissions=Permission::all();
        return view('role.add',compact('permissions'));
    }

    //保存添加的角色信息到数据表 roles中
    public function store(Request $request){
       // dump($_POST);

        //添加管理员角色信息到roles表中
        $role=Role::create([
            'name'=>$request->name
        ]);

        //添加保存 根据传入的权限id得到查询出来的 权限对象，保存在一个 数组中
        $permissions=[];

        foreach($request->permission as $p){
            //dump($p);
            $permissions[]=Permission::where('id','=',$p)->first();
        }
        //dump($permissions);

        //添加管理员角色信息，同时插入权限到 roles 关联表中
        $role->syncPermissions($permissions);
        //$permission->syncRoles($roles);

        return '添加角色成功';
    }

    //显示所有的角色列表
    public function index(){
        $roles=Role::Paginate(2);
        return view('role.index',compact('roles'));
    }

    //编辑指定的角色数据
    public function edit(Role $role){
        //dd($role->id);
        //根据传入的管理员角色id查询 role_has_permissions中的数据
        $permissions=DB::table('role_has_permissions')->where('role_id','=',$role->id)->get();

        //dump($permissions);
        //根据管理员角色管理表中的permission_id得到permission的数据，让修改界面显示出来
        $permiss=[];
        foreach($permissions as $permission){
            //dump($permission);
            $permiss[]=DB::table('permissions')->where('id','=',$permission->permission_id)->value('id');
        }

        //dd($permiss);
        //存放拿出来的id值
     /*   $ps_id=[];

        foreach($permiss as $ps){
           // dump($ps->id);
           $ps_id[]=$ps->id;
        }*/

        //查询permissions表中的所有数据，放在表中
        $pers=Permission::all();
        //dump($permiss,$pers);
//dd($ps_id);
        return view('role.edit',compact('role','pers','permiss'));
    }

    //保存修改的数据
    public function update(Role $role,Request $request){
        //dd($role,$_POST);

        //修改指定的数据到roles中
        $role->update([
            'name'=>$request->name
        ]);

        //保存查询出来的权限对象到数组中，进行重新修改权限
        $peress=[];
        foreach($request->permission as $p){
            //dump($p);
            $peress[]=Permission::where('id','=',$p)->first();
        }

        //修改管理员角色表的时候，同时修改权限信息
        $role->syncPermissions($peress);//修改的时候==》》不用管上面的是不是修改的时候得到的数据，直接使用，就删除前面的，插入现在的

        return '修改成功';
    }

    //删除指定的角色数据
    public function destroy(Role $role){
        $role->delete();
        return '删除'.$role->name.'成功';
}

}
