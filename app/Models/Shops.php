<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopCategories;

class Shops extends Model
{
    //规定要使用的表
    protected $table='shops';
    //规定要操作的报的属性字段
    protected $fillable=['shop_category_id','shop_name','shop_img','shop_rating','brand','on_time','fengniao','bao','piao','zhun','start_zend','start_cost','notice','discount','status','shop_cateid'];

    //一对多得到上架分类的数据渲染  主表 shops： shop_category_id ==>> 从表 shop_categories_id

    public function cateShop(){
        return $this->belongsTo(ShopCategories::class,'shop_category_id','id');
    }


    //定义一对一的数据操作：shops id ==>> users shop_id
    public function detailInfo(){

        return $this->belongsTo(User::class,'id','shop_id');
    }



}
