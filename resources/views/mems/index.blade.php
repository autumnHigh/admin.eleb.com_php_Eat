@extends('layOut.default_model')

@section('contents')
    @auth


        {{--根据username查询得到符合的数据，显示在页面上--}}
        <form action="{{route('mems.index')}}" method="get">
            <input type="text" name="username"/>
            <button class="btn btn-primary">搜索</button>

        </form>




<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>会员名称</th>
        <th>会员电话</th>
        <th>会员状态</th>
        <th>操作</th>
    </tr>
    @foreach($mems as $mem)
        <tr>
            <td>{{$mem->id}}</td>
            <td>{{$mem->username}}</td>
            <td>{{$mem->tel}}</td>
            <td>{{$mem->status==0?'使用中':'禁用中'}}</td>
           <td>
               <a href="{{route('mems.edit',[$mem])}}" @if($mem->status==0) class="btn btn-danger" @else class="btn btn-success" @endif>{{$mem->status==0?'禁用':'开启使用'}}</a>
                <a href="{{route('mems.info',[$mem])}}" class="btn btn-primary">详情</a>
           </td>

        </tr>
    @endforeach
</table>
{{$mems->links()}}
    @endauth

    @guest
        <a href="{{route('session.create')}}">登陆操作</a>
    @endguest

@endsection