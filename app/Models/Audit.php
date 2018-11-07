<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shops;
use App\Models\User;
class Audit extends Model
{

    Protected $table='shops';

    //定义一对一的数据操作：shops id ==>> users shop_id
    public function user(){

        return $this->belongsTo(User::class,'id','shop_id');
    }

}
