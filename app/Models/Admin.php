<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends \Illuminate\Foundation\Auth\User
{
    use Notifiable;

    use HasRoles;

    //声明要操作得标
    protected $table='admins';
    //声明要操作的数据操作
    protected $fillable=['name','email','password','remember_token'];
}
