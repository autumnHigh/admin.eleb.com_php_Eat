<?php

namespace App\Http\Controllers\Admins;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //显示 周订单
    public function week(){

    $date=[];
    $alls=[];

    //图标元素收集
        $down='';
        $line='';

        for($i=0;$i<=6;++$i){
            $start=date('Y-m-d',strtotime("-{$i} day"))/*.' 00:00:01'*/;
            $end=date('Y-m-d',strtotime("-{$i} day"))/*.' 23:59:59'*/;
           // dump($start,$end);

            $all= DB::select("select count(*) count from orders where created_at >= ? and created_at <= ?",[$start.' 00:00:01',$end.' 23:59:59']);

           // dump($start,$all[0]->count);
            $alls[]=$all[0]->count;

            $date[]=$start;

            $down=json_encode($date);

            $line=json_encode($alls);
        }
dump($down,$line);
//dump($ddata);
        return view('ordersize.week',compact('date','alls','line','down'));
    }



    //三个月订单报表模块
    public function threeMonth(){

        //获取今天 0点的时间戳
        $start_time = strtotime(date("Y-m"));//或者Y-m-d H:i:s

        /* $time1=strtotime("0 month",$start_time);
      $time2=strtotime("-1 month",$start_time);
      $time3=strtotime("-2 month",$start_time);*/

        //定义图标所需的素材
        $datas='';
        $months='';

        for($i=0;$i<=2;++$i){
            $time=strtotime("-{$i} month",$start_time);
            $start=date('Y-m',$time);
           /* $end=date('Y-m',$time);*/
           // dump($start,$end);
            $all=DB::select("select count(*) as count from orders where DATE(created_at) >= ? and DATE(created_at) <= ? ",[$start.'-01',$start.'-31']);
       // dump($all);
$datas[]=$start;
            foreach($all as $a){
                //dump($a->count);
                $months[]=$a->count;

            }

        }

        dump($datas,$months);

    return view('ordersize.threemonth',compact('datas','months'));

    }


    //平台断最近一周上架菜品销量统计
    public function weekMenu(){
        //dd(111);

       /* for($i=0;$i<=6;++$i){

            //获取今天 0点的时间戳
            $start_time = strtotime(date("Y-m-d"));//或者Y-m-d H:i:s

            $time=strtotime("-{$i} day",$start_time);
            $start=date('Y-m-d',$time);
            $end=date('Y-m-d',$time);

            //dump($start,$end);

        $all=DB::select("select DATE(od.created_at) as date,od.goods_id as goods_id,sum(od.amount) as sum from orders left join order_details od on od.order_id=orders.id left join menus m on m.id=od.goods_id where DATE(od.created_at) >= ? and DATE(od.created_at) <= ? group by DATE(od.created_at),od.goods_id",[$start,$end]);
        dump($all);


        }*/
        //测试阶段，设置一个默认的商铺
        $shop_id = 32;//Auth::user()->shop_id;

        $time_start = date('Y-m-d 00:00:00',strtotime('-6 day'));
        $time_end = date('Y-m-d 23:59:59');
        $sql = "SELECT DATE(orders.created_at) AS date,order_details.goods_id,SUM(order_details.amount) AS total FROM order_details JOIN orders ON order_details.order_id = orders.id WHERE orders.created_at >= '{$time_start}' and orders.created_at <= '{$time_end}' AND shop_id = {$shop_id} GROUP BY DATE(orders.created_at),order_details.goods_id";

       // dump($sql);
       // exit;
        $rows = DB::select($sql);//得到七天的数据
       // dd($rows);
        //$rows = [
        // ['date'=>'','total'=>''],[]
        //];

        //构造7天统计格式
        $result = [];
        //获取当前商家的菜品列表,只选择字段 id 商品id,goods_name商品名
        //$menus = Menu::where('shop_id',$shop_id)->select(['id','goods_name'])->get();
        $menus = Menu::where('shop_id',$shop_id)->select(['id','goods_name'])->get();
       // dump($menus);//二维数组对象。
       // exit;

        //转换二维数组为一维
        $keyed = $menus->mapWithKeys(function ($item) {
            return [$item['id'] => $item['goods_name']];//将二维数组中的id和goods_name,变更为一维数组，
            //[ id => 'goods_name',
            //  1 => 稀粥————，
            //   2 => 皮蛋粥,
            //      ....
            //]
        });

        $keyed2 = $menus->mapWithKeys(function ($item) {
            return [$item['id'] => 0];
        });

        //最开始是一个对象数组
        //dump($keyed);

        //使用$keyed->all() , 得到对象中的所有数据
        //dump($keyed->all());//一维数组

        $menus = $keyed->all();

        //菜品名列表，一维数组
        //dd($menus);


        //得到一周的时间日期
        $week=[];
        for ($i=6;$i>=0;--$i){
            $week[] = date('Y-m-d',strtotime("-{$i} day"));
        }

        //dd($week);

        foreach ($menus as $id=>$name){//$id==> menus中的键id，$name=>goods_name,那么id的值就是对应的date数据
           // dump($id,$name);
            foreach ($week as $day){//循环得到一周的日期，放入到 指定的菜品的id的数组中
                $result[$id][$day] = 0;//把一周的时间内的菜品的数量都设置为0
            }

        }

       // dd($result);

        foreach ($rows as $row){
            //dump($row);
            //原声查询语句，得到的三个参数：goods_id，date，total
            //将goods_id作为键，日期时间date作为数组键值，total总量作为数组日期键中的值：1=>['2018-10-28'=>0,'2018-10-28'=>4,...]

            //因为前面存储的result中的id就是有菜品时间，当时间相同的时候后就把  菜品的总是存放到对应的 数组中
            $result[$row->goods_id][$row->date]=$row->total;//每一个菜品时间后面存放对应的数量
           // dump($result[$row->goods_id][$row->date]);
        }

        //dump($result);

        $series = [];
        foreach ($result as $id=>$data){//$key => $val 设置 【id键】对应 值
            //dump($id);
            $serie = [
                'name'=> $menus[$id],//因为前面设置了id对应的值，所以这里输出的就是 goods_name
                'type'=>'line',//线性标的参数
                'stack'=> '销量',//形态表说明类型
                'data'=>array_values($data) //将菜品数量的id 放在数组中，和里面的值，进行对应，必要里面的键 '2018-10-28'..
            ];

            //dump($id,array_values($data));
            $series[] = $serie;
        }
        /* [
                 {
                     name:'回锅肉',
                     type:'line',
                     stack: '总量',
                     data:[120, 132, 101, 134, 90, 230, 210]
                 },
                 {
                     name:'联盟广告',
                     type:'line',
                     stack: '总量',
                     data:[220, 182, 191, 234, 290, 330, 310]
                 },
                 {
                     name:'视频广告',
                     type:'line',
                     stack: '总量',
                     data:[150, 232, 201, 154, 190, 330, 410]
                 },
                 {
                     name:'直接访问',
                     type:'line',
                     stack: '总量',
                     data:[320, 332, 301, 334, 390, 330, 320]
                 },
                 {
                     name:'搜索引擎',
                     type:'line',
                     stack: '总量',
                     data:[820, 932, 901, 934, 1290, 1330, 1320]
                 }
             ]*/

       //dump($week,$menus,$series);

        return view('ordersize.weekMenu',compact('result','menus','week','series'));

    }


    //菜品分类三个月的销售报表
    public function threeMonthMenu(){

        //定义一个临时变量给测试商铺三个月的菜品销售情况
        $shop_id=32;

        //设置月份的保存
        $months=[];


        //外部定义一个可以保存查询返回的数据的变量
        $rowss='';

$year=[];
        for($i=2;$i>=0;--$i){
            $year[]=date('Y-m',strtotime("-{$i} month"));

            /*$months[]=$year;*/
        }
        //dump($months);
       // exit;
        dump($year);
        //循环得到当前月份往前的三个月的菜品销售数据
        for($i=2;$i>=0;--$i){

            $month=date('m',strtotime("-{$i} month"));
//dump($month);
            $months[]=$month;
            $rows=DB::select("select MONTH(od.created_at) as date,od.goods_id as goods_id,sum(od.amount) as total from orders left join order_details od on od.order_id=orders.id where MONTH(od.created_at) = ?  group by MONTH(od.created_at),od.goods_id",[$month]);
$rowss=$rows;
           //dump($rows);

        }
        //dump($rowss);

        //获取商家的菜品列表数据
        $menus = Menu::where('shop_id',$shop_id)->select(['id','goods_name'])->get();
       // dump($menus);

        //把取出来的菜品列表数据转化为 一维数组 同事去除的 id当做键名， godos_name当做键值
        $keyed = $menus->mapWithKeys(function ($item) {
            return [$item['id'] => $item['goods_name']];
        });

        $menus=$keyed->all();
       // dd($menus);
        //构造 月份 统计格式
        $result = [];
       // dump($months,$keyed->all());
        //循环菜品列表数据，将 $key => $val 模式 ： $id=>$name ==> '1' => 稀粥+++ ，。。。
        foreach($menus as $id=>$name){
            //dump($id);
            foreach($months as $month){
                //dump($month);
                $result[$id][$month] = 0;//给没有菜品的数量统计为0，自动填充
               // dump($result[$id][$month]);
            }
        }
        //dump($result);
        //dd($result);

        //dd($rowss);


        //循环查询语句返回的数据，得到数量，再往符合的时间段的数组中【一一对应】
        foreach($rowss as $row){
           // dump($row);
            $result[$row->goods_id][$row->date] = $row->total;

        }

        //dd($result);

        //定义一个空数组，存储图表需要的数据
        $series=[];
        foreach($result as $id=>$data){
            //dump($id);
            $serie = [
                'name'=> $menus[$id],
                'type'=>'line',
                'stack'=> '销量',
                'data'=>array_values($data)
            ];
           // dump($serie);
            $series[]=$serie;

        }

        //dump($series);
        return view("ordersize.threeMonthMenu",compact('result','months','menus','series','year'));

    }

}
