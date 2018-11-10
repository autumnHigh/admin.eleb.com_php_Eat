<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Nav extends Model
{
    //定义要操作的数据表 navs
    protected $talbe='navs';
    //定义要操作的属性字段
    protected $fillable=['name','url','permission_id','pid'];

    //显示菜单数据到导航栏上
    public static function list(){

        if(Auth::check()){
            //查询所有的navs导航 为顶级菜单的数据
            $navs=Nav::where('pid','=',9)->get();
            //dump($navs);
            //先定义一个空的变量保存数据，每次都会重置数据
            $html = '';

            foreach($navs as $nav){
                // dump($nav->id);
                $nav_lan='';//一级循环参数

                $kid_kk='';//二级循环参数

                $nav_lan .= '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$nav->name.'<span class="caret"></span></a>
                    <ul class="dropdown-menu">';

                //查询顶级菜单下面的次级菜单
                $kid=Nav::where('pid','=',$nav->id)->get();
                foreach($kid as $kk){
                    // dump($kk->id);

                    //验证是否拥有权限，可以显示菜单信息,直接使用rbac的
                    if(Auth::user()->can($kk->url)){//这里扫描的是权限表；permissions的数据？
                        $kid_kk .= '<li><a href="'.$kk->url.'">'.$kk->name.'</a></li>';
                    }

                }
                $nav_lan .= $kid_kk;//如果有值。就直接赋值

                $nav_lan .='</ul></li>';

                if($kid_kk){
                    /* ;*/
                    $html.=$nav_lan;
                }
            }
            return $html;
        }else{
            return $html='';
        }


    }

}
