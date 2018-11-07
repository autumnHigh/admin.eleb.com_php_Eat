@extends('layOut.default_model')

@section('contents')
    @auth

        {{--这是活动状态的选中栏--}}
        <a href="{{route('active.index')}}?id=1" class="btn btn-primary">未开始</a>
        <a href="{{route('active.index')}}?id=2" class="btn btn-primary">进行中</a>
        <a href="{{route('active.index')}}?id=3" class="btn btn-primary">已结束</a>



<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>活动名</th>
        <th>活动内容</th>
        <th>活动开始时间</th>
        <th>活动结束时间</th>
        <th>操作</th>
    </tr>
    @foreach($actives as $active)
        <tr>
            <td>{{$active->id}}</td>
            <td>{{$active->title}}</td>
            <td>
                {!! $active->content !!}</td>
            <td>{{$active->start_time}}</td>
            <td>{{$active->end_time}}</td>

            <td>
                <a href="{{route('active.edit',['active'=>$active])}}" class="btn btn-success">编辑</a>

                <form action="{{route('active.destroy',[$active])}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                <button class="btn btn-warning">删除</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{$actives->appends(['id'=>$data])->links()}}
    @endauth

    @guest
        <a href="{{route('session.create')}}">登陆操作</a>
    @endguest

@endsection