<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UpController extends Controller
{
    //上传文件或者图片到阿里云oss存储的方法
    public function upload(Request $request){
        $path=$request->file('file')->store('public/img');
        return ['path'=>Storage::url($path)];
    }
}
