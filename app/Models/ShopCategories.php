<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategories extends Model
{
    //定义规定的表
    protected $table='shop_categories';
    //规定要操作的属性字段
    protected $fillable=['name','img','status','cover'];
}
