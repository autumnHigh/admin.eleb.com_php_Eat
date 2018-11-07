<?php

namespace App\Http\Controllers\Admins;

use App\Models\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class NavController extends Controller
{
    //显示添加节点的页面
    public function create(){
        //查询navs导航表的数据
        $navs=Nav::all();
        //dump($navs);
        //查询所有的权限里面的内容
        $permissions=Permission::all();
       // dump($permissions);
        return view('nav.add',compact('navs','permissions'));
    }

    //保存添加的菜单菜单信息
    public function store(Request $request){

        /*$this->validate($request,[
            'name'=>'required',
            'pid'=>'required',
            //'url'=>'required',
        ],[
            'name.required'=>'菜单名不能为空',
            'pid.required'=>'上级菜单不能为空',
            //'url.required'=>'节点不能为空',
        ]);*/

        //手动添加验证
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'pid' => 'required',
            //'url' => 'required',
        ],[
            'name.required'=>'菜单名不能为空',
            'pid.required'=>'上级菜单不能为空',
            //'url.required'=>'节点不能为空',
        ])->validate();//自动回到提交错误信息的节点

       // dd($_POST);
        Nav::create([
            'name'=>$request->name,
            'pid'=>$request->pid,
            'url'=>$request->url
        ]);

        //return '添加一级菜单成功';
        return redirect()->route('nav.index')->with('success','添加导航成功');
    }

    //添加二级菜单
    public function twomenu(){
        //查询菜单中pid为0的顶级菜单
        $navs=Nav::all();
        //dd($navs);
        return view('nav.addtwo',compact('navs'));
    }

    //保存添加的二级菜单
    public function twostore(Request $request){
       // dd($_POST,$request->name);

        //手动添加验证
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'pid' => 'required',
            'url' => 'required',
        ],[
            'name.required'=>'菜单名不能为空',
            'pid.required'=>'上级菜单不能为空',
            'url.required'=>'节点不能为空',
        ])->validate();//自动回到提交错误信息的节点

       // exit;

        //添加数据到数据表navs
        Nav::create([
            'name'=>$request->name,
            'pid'=>$request->pid,
            'url'=>$request->url
        ]);

        dd('添加二级菜单成功');

    }

    //显示所有的导航栏 navs 信息
    public function index(){
        $navs=Nav::Paginate(7);
        return view('nav.index',compact('navs'));
    }

    //编辑指定的一条数据
    public function edit(Nav $nav,Request $request){
        dump($nav->url);
        //查询navs导航表中的的所有数据
        $navs=Nav::all();
        //dd($nav);
        //查询所有的权限里面的内容
        $permissions=Permission::all();

        return view('nav.edit',compact('navs','nav','permissions'));
    }

    //保存修改的数据
    public function update(Nav $nav,Request $request){
        //dd($nav);
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'url'=>'required',
            'pid'=>'required'
        ],[
            'name.required'=>'菜单名不能为空',
            'pid.required'=>'pid上一级目录不能为空',
            'url.required'=>'节点不能为空',
        ])->validate();

        $nav->update([
            'name'=>$request->name,
            'pid'=>$request->pid,
            'url'=>$request->url
        ]);

        return '修改菜单成功';

    }

    //删除指定的数据
    public function destroy(Nav $nav){

        // 传入的菜单的id ，查询navs导航表中的有下级菜单的数据，如果有就不允许删除，如果没有就执行删除
        $hasnav=Nav::where('pid','=',$nav->id)->get();
        dump(count($hasnav));
        if(count($hasnav) == 0){
            dump(111);
            $nav->delete();
            return redirect()->route('nav.index')->with('success','删除成功');
        }else{
            dump(222);
            return redirect()->route('nav.index')->with('warning','菜单下有其他数据，不能删除');
        }

    }






}
