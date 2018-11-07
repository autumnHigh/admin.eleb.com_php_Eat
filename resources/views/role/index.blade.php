@extends('layOut.default_model')

@section('contents')
    @auth
<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>角色名</th>

        <th>操作</th>
    </tr>
    @foreach($roles as $role)
        <tr>
            <td>{{$role->id}}</td>
            <td>{{$role->name}}</td>
            <td>
                <a href="{{route('role.edit',[$role])}}" class="btn btn-success">编辑</a>

                <form action="{{route('role.destroy',[$role])}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                <button class="btn btn-warning">删除</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{$roles->links()}}
    @endauth

    @guest
        <a href="{{route('session.create')}}">登陆操作</a>
    @endguest

@endsection