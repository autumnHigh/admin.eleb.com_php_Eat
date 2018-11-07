@extends('layOut.default_model')

@section('contents')
    @auth
<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>权限名</th>

        <th>操作</th>
    </tr>
    @foreach($permissions as $permission)
        <tr>
            <td>{{$permission->id}}</td>
            <td>{{$permission->name}}</td>
            <td>
                <a href="{{route('permission.edit',[$permission])}}" class="btn btn-success">编辑</a>

                <form action="{{route('permission.destroy',[$permission])}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                <button class="btn btn-warning">删除</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{$permissions->links()}}
    @endauth

    @guest
        <a href="{{route('session.create')}}">登陆操作</a>
    @endguest

@endsection