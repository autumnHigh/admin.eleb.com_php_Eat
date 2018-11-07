@extends('layOut.default_model')

@section('contents')
    @auth
<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>名字</th>
        <th>邮件</th>
        <th>操作</th>
    </tr>
    @foreach($admins as $admin)
        <tr>
            <td>{{$admin->id}}</td>
            <td>{{$admin->name}}</td>
            <td>{{$admin->email}}</td>
            <td>
                <a href="{{route('admin.edit',['admin'=>$admin])}}" class="btn btn-success">编辑</a>

                <form action="{{route('admin.destroy',[$admin])}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                <button class="btn btn-warning">删除</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{$admins->links()}}
    @endauth

    @guest
        <a href="{{route('session.create')}}">登陆操作</a>
    @endguest

@endsection