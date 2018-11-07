<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shops;
use App\Models\ShopCategories;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class ShopsController extends Controller
{

    public function __construct(){
        $this->middleware('auth',[
            'except'=>['index'],
        ]);
    }


    //添加商品信息表 表单
    public function create(){

        $shop_category_id=ShopCategories::all();
        //dd($shop_category_id);
        return view('shops.add',compact('shop_category_id'));
    }

    //保存新增的数据
    public function store(Request $request){


       // dd($_POST);

        DB::beginTransaction();

        try{
            $this->validate($request,[
                'name'=>'required',
                'password'=>'required',
                'email'=>'email|required',
                'shop_cateid'=>'required',
                'shop_name'=>'required',
                'shop_rating'=>'required',
                'start_zend'=>'required',
                'start_cost'=>'required',
                'notice'=>'required',
                'discount'=>'required',

            ],[
                'name.required'=>'商户名不能为空',
                'password.required'=>'商户密码不能为空',
                'email.required'=>'邮件不能为空',
                'email.email'=>'邮件输入错误',
                'shop_cateid.required'=>'商铺分了不能为空',
                'shop_name.required'=>'商铺名不能为空',
                'shop_rating.required'=>'评分不能为空',
                'start_zend.required'=>'起送金额',
                'start_cost.required'=>'配送费',
                'notice.required'=>'店公告',
                'discount.required'=>'优惠信息',

            ]);


            if($request->img){
               // $path=$request->file('cover')->store('public/shops');
                // dd($path);
                //平台添加商品，默认为通过
                $status='1';

                $shops=Shops::create([
                    'shop_category_id'=>$request->shop_cateid,
                    'shop_name'=>$request->shop_name,
                    'shop_rating'=>$request->shop_rating,
                    'brand'=>$request->brand,
                    'on_time'=>$request->on_time,
                    'fengniao'=>$request->fengniao,
                    'bao'=>$request->bao,
                    'piao'=>$request->piao,
                    'zhun'=>$request->zhun,
                    'start_zend'=>$request->start_zend,
                    'start_cost'=>$request->start_cost,
                    'notice'=>$request->notice,
                    'discount'=>$request->discount,
                    'status'=>$status,
                    'shop_img'=>$request->img,
                ]);

                //获取创建的商户信息数据id，传递到商户账号表中
                $lastId=$shops->id;
                dump($lastId,'有图片');

                //创建商户信息表数据
                User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=> bcrypt($request->password),
                    'remember_token'=>str_random('50'),
                    'shop_id'=>$lastId,
                ]);


            }else{
                //平台添加商品，默认为通过
                $status='1';

                $shops=Shops::create([
                    'shop_category_id'=>$request->shop_cateid,
                    'shop_name'=>$request->shop_name,
                    'shop_rating'=>$request->shop_rating,
                    'brand'=>$request->brand,
                    'on_time'=>$request->on_time,
                    'fengniao'=>$request->fengniao,
                    'bao'=>$request->bao,
                    'piao'=>$request->piao,
                    'zhun'=>$request->zhun,
                    'start_zend'=>$request->start_zend,
                    'start_cost'=>$request->start_cost,
                    'discount'=>$request->discount,
                    'notice'=>$request->notice,
                    'status'=>$status,

                ]);

                $lastId=$shops->id;
                dump($lastId,'没图片');


                //创建商户信息表数据
                User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'remember_token'=>str_random('50'),
                    'shop_id'=>$lastId,
                ]);

            }

            //事务提交
            DB::commit();

        }catch(\Exception $e){
            //事务捕捉错误，数据回滚
            DB::rollBack();
        }

        return redirect()->route('shops.index')->with('success','添加商铺和账户信息成功');
    }

    //显示商品表的所有数据到主页面上
    public function index(){
        $shops=Shops::Paginate(1);
        //dd($shops);
        return view('shops.index',compact('shops'));
    }

    //编辑指定的某一条数据
    public function edit(Shops $shop){
        //dump($shop);
        $shop_category_id=ShopCategories::all();
        return view('shops.edit',compact('shop','shop_category_id'));
    }

    //保存编辑状态数据
    public function update(Shops $shop,Request $request){
        //dd($shop->id,$request->file('cover'));
       // dd($shop);
        $this->validate($request,[
            'shop_cateid'=>'required',
            'shop_name'=>'required',
            'shop_rating'=>'required',
            'start_zend'=>'required',
            'start_cost'=>'required',
            'notice'=>'required',
            'discount'=>'required',

        ],[
            'shop_cateid.required'=>'商铺分类不能为空',
            'shop_name.required'=>'商铺名不能为空',
            'shop_rating.required'=>'评分不能为空',
            'start_zend.required'=>'起送金额',
            'start_cost.required'=>'配送费',
            'notice.required'=>'店公告',
            'discount.required'=>'优惠信息',

        ]);


        //$old=Shops::where('id','=',$shop->id)->first();
        //dd($old->shop_img);

        if($request->img){


           // Storage::delete($old->shop_img);
            //获得上传的文件并且，给个保存地址
            //$path=$request->file('cover')->store('public/shops');

            $shop->update([
                'shop_category_id'=>$request->shop_cateid,
                'shop_name'=>$request->shop_name,
                'shop_rating'=>$request->shop_rating,
                'brand'=>$request->brand,
                'on_time'=>$request->on_time,
                'fengniao'=>$request->fengniao,
                'bao'=>$request->bao,
                'piao'=>$request->piao,
                'zhun'=>$request->zhun,
                'start_zend'=>$request->start_zend,
                'start_cost'=>$request->start_cost,
                'discount'=>$request->discount,
                'notice'=>$request->notice,
                'status'=>$request->status,
                'shop_img'=>$request->img,
            ]);

        }else{

            $shop->update([
                'shop_category_id'=>$request->shop_cateid,
                'shop_name'=>$request->shop_name,
                'shop_rating'=>$request->shop_rating,
                'brand'=>$request->brand,
                'on_time'=>$request->on_time,
                'fengniao'=>$request->fengniao,
                'bao'=>$request->bao,
                'piao'=>$request->piao,
                'zhun'=>$request->zhun,
                'start_zend'=>$request->start_zend,
                'start_cost'=>$request->start_cost,
                'discount'=>$request->discount,
                'notice'=>$request->notice,
                'status'=>$request->status,
            ]);

        }

        return redirect()->route('shops.index')->with('success','修改商铺信息成功');


    }


    //删除指定的一条数据
    public function destroy(Shops $shop){

        //dd($shop->id);
        //查询得到图片的地址，上穿文件的文件库的文件，删除掉
        $old=Shops::where('id','=',$shop->id)->first();
        //dd($old->shop_img);

        //执行删除上传文件的命令
        Storage::delete($old->shop_img);

        //删除商铺数据的时候需要删除商铺账户标的数据吗？
       /* $userInfo=User::where('shop_id','=',$shop->id)->first();
        dd($userInfo);
        $shop->delete();*/
        //删除自己本身的指定的数据
        $shop->delete();

        User::where('shop_id','=',$shop->id)->delete();


        return redirect()->route('shops.index')->with('success','删除商铺和账户信息成功');
    }

    //显示没有被审核的数据 shops表中的status == 0 的数据
    public function show(){
        /*$audits=Shops::where('status','=','0')->Paginate(1);*/
        //$audits=DB::table('shops')->join('users','shops.id','=','users.shop_id')->select('users.*','shops.status as shopStatus','shops.shop_name')->get();

        $audits=Shops::where('status','=','0')->get();

        //dd($audits);
        return view('audit.index',compact('audits'));
    }


}
