@extends('layOut.default_model')

@section('contents')
    @auth


       <h1>id:<p>{{$mem->id}}</p></h1>
       <h1> 用户名:<p>{{$mem->username}}</p></h1>
       <h1> 电话号码:<p>{{$mem->tel}}</p></h1>
       <h1> 创建时间:<p>{{$mem->created_at}}</p></h1>
       <h1> 用户状态值<p>{{$mem->status==0?'可用状态进行中':'禁止使用中'}}</p></h1>


       <a href="javascript:history.go(-1)" class="btn btn-primary">返回上一步</a>

    @endauth

    @guest
        <a href="{{route('session.create')}}">登陆操作</a>
    @endguest

@endsection